<?php

namespace App\Http\Livewire\Admin\Users;
use App\Http\Livewire\BaseComponent;
use App\Models\Notification;
use App\Models\Overtime;
use App\Models\Schedule;
use App\Models\Setting;
use App\Sends\SendMessages;
use App\Traits\Admin\TextBuilder;
use Bavix\Wallet\Exceptions\BalanceIsEmpty;
use Bavix\Wallet\Exceptions\InsufficientFunds;
use Bavix\Wallet\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class StoreUsers extends BaseComponent
{
    use AuthorizesRequests , TextBuilder ;
    public $user , $mode , $header ,$data = [] , $userRole = [] , $password ;
    public $name  , $user_name , $phone  , $status  , $actionWallet , $editWallet , $sendMessage , $subjectMessage,
        $statusMessage , $result , $walletMessage     , $userWallet;
    // schedules
    public $saturday , $sunday , $monday , $tuesday , $wednesday, $thursday, $friday;
    // overtimes
    public $start_at , $end_at , $overtimes = [];

    public function mount($action , $id = null)
    {
        $this->authorize('show_users');
        if ($action == 'edit')
        {
            $this->header = 'کاربر شماره '.$id;
            $this->user = User::findOrFail($id);
            $this->name = $this->user->name;
            $this->user_name = $this->user->user_name;
            $this->phone = $this->user->phone;
            $this->status = $this->user->status;
            $this->userRole = $this->user->roles()->pluck('name','id')->toArray();;
            $this->result = $this->user->results;
            $this->userWallet = $this->user->walletTransactions()->where('confirmed', 1)->get();
            $this->result = $this->user->alerts;
            $this->saturday = $this->user->schedule->saturday ?? null;
            $this->sunday = $this->user->schedule->sunday ?? null;
            $this->monday = $this->user->schedule->monday ?? null;
            $this->tuesday = $this->user->schedule->tuesday ?? null;
            $this->wednesday = $this->user->schedule->wednesday ?? null;
            $this->thursday = $this->user->schedule->thursday ?? null;
            $this->friday = $this->user->schedule->friday ?? null;
        } elseif($action == 'create')
            $this->header = 'کاربر جدید';
        else abort(404);

        $this->mode = $action;
        $this->data['status'] = User::getStatus();
        $this->data['role'] = Role::whereNotIn('name', ['administrator', 'super_admin'])->latest()->get();
        $this->data['action'] = [
            'deposit' => 'واریز',
            'withdraw' => 'برداشت',
        ];
        $this->data['subjectMessage'] = Notification::getSubject();
    }

    public function store()
    {
        $this->authorize('edit_users');
        if ($this->mode == 'edit')
            $this->saveInDataBase($this->user);
        else {
            $this->saveInDataBase(new User());
            $this->reset([
                'name','user_name','password','phone', 'status'
            ]);
        }
    }

    public function saveInDataBase(User $model)
    {
        $fields = [
            'name' => ['required', 'string','max:255'],
            'user_name' => ['required', 'string','max:255' , 'unique:users,user_name,'. ($this->user->id ?? 0)],
            'phone' => ['required', 'size:11' , 'unique:users,phone,'. ($this->user->id ?? 0)],
            'status' => ['required','in:'.implode(',',array_keys(User::getStatus()))],
        ];
        $messages = [
            'name' => 'نام ',
            'user_name' => 'نام کربری',
            'phone' => 'شماره همراه',
            'status' => 'وضعیت',
        ];

        if ($this->mode == 'create' && isset($this->pass_word))
        {
            $fields['password'] = ['required','min:'.Setting::getSingleRow('password_length'),'regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9]).*$/'];
            $messages['password'] = 'گذرواژه';
        }

        if (isset($this->actionWallet))
        {
            $fields['editWallet'] = ['required','numeric','between:0,9999999999.99'];
            $messages['editWallet'] = 'عملیات';
        }

        $this->validate($fields,[],$messages);
        if ($this->mode == 'edit' && $this->status <> $this->user->status)
            $this->notify();

        $model->name = $this->name;
        $model->user_name = $this->user_name;
        $model->phone = $this->phone;
        $model->status = $this->status;
        $model->ip = 12;
        if ($this->mode == 'create' && isset($this->password))
            $model->password = $this->password;

        $model->save();

        Schedule::updateOrCreate(['user_id'=>$model->id],[
            'saturday' => $this->saturday,'sunday' => $this->sunday,'monday' => $this->monday,'tuesday' => $this->tuesday,
            'wednesday' => $this->wednesday,'thursday' => $this->thursday,'friday'=> $this->friday
        ]);

        if (auth()->user()->hasRole('super_admin'))
            $model->syncRoles($this->userRole);

        $this->emitNotify('اطلاعات با موفقیت ثبت شد');
    }

    public function wallet()
    {
        $this->authorize('edit_users');
        if ($this->mode == 'edit')
        {
            $this->validate([
                'actionWallet' => ['required' ,'in:deposit,withdraw'],
                'editWallet' => ['required','numeric','between:0,999999999.9999'],
                'walletMessage' => ['nullable','string','max:150'],
            ] , [] ,[
                'actionWallet' => 'عملیات',
                'editWallet' => 'مبلغ',
                'walletMessage' => 'متن پیام',
            ]);
            if ($this->actionWallet == Transaction::TYPE_DEPOSIT) {
                $this->user->deposit($this->editWallet, ['description' => $this->walletMessage, 'from_admin'=> true]);
            } else {
                try {
                    $this->user->forceWithdraw($this->editWallet, ['description' => $this->walletMessage, 'from_admin'=> true]);
                } catch (BalanceIsEmpty | InsufficientFunds $exception) {
                    $this->addError('walletAmount', $exception->getMessage());
                }
            }
            $this->userWallet = $this->user->walletTransactions()->where('confirmed', 1)->get();
            $this->reset(['actionWallet', 'editWallet', 'walletMessage']);
            $this->emitNotify('کیف پول کاربر با موفقیت ویرایش شد');
        }
    }

    public function sendMessage()
    {
        $this->authorize('edit_users');
        if ($this->mode == 'edit')
        {
            $this->validate([
                'sendMessage' => ['required' ,' string','max:255'],
                'subjectMessage' => ['string','required','in:'.implode(',',array_keys($this->data['subjectMessage']))],
            ] , [] ,[
                'sendMessage' => 'متن پیام',
                'subjectMessage' => 'موضوع',
            ]);
            $result = new Notification();
            $result->subject = $this->subjectMessage;
            $result->content = $this->sendMessage;
            $result->type = Notification::PRIVATE;
            $result->user_id = $this->user->id;
            $result->model = $this->subjectMessage;
            $result->model_id = null;
            $result->save();
            $this->result->push($result);
            $this->reset(['sendMessage','subjectMessage']);
            $this->emitNotify('اطلاعات با موفقیت ثبت شد');
        }
    }

    public function render()
    {
        if ($this->mode == 'edit') {
            $this->overtimes = Overtime::where('user_id',$this->user->id)->get();
        }

        return view('livewire.admin.users.store-users')->extends('livewire.admin.layouts.admin');
    }

    public function notify()
    {
        $text = [];
        switch ($this->status){
            case User::NOT_CONFIRMED:{
                $text = $this->createText('not_confirmed',$this->user);
                break;
            }
            case User::CONFIRMED:{
                $text = $this->createText('auth',$this->user);
                break;
            }
        }
        $send = new SendMessages();
        $send->sends($text,$this->user,Notification::User,$this->user->id);
    }


    public function deleteOverTimer($id)
    {
        $this->authorize('edit_users');
        Overtime::findOrfail($id)->delete();
    }

    public function newOverTime()
    {
        $this->authorize('edit_users');
        if ($this->mode == 'edit'){
            $this->validate([
                'start_at' => ['required','date_format:Y-m-d H:i'],
                'end_at' => ['required','date_format:Y-m-d H:i'],
            ],[],[
                'start_at' => 'تاریخ شروع',
                'end_at' => 'تاریخ پایان',
            ]);
            $overtime = new Overtime();
            $overtime->user_id = $this->user->id;
            $overtime->start_at = $this->start_at;
            $overtime->end_at = $this->end_at;
            $overtime->manger = auth()->id();
            $overtime->save();
            $this->reset(['start_at','end_at']);
            $this->emitNotify('اطلاعات با موفقیت ثبت شد');
        }
    }

}
