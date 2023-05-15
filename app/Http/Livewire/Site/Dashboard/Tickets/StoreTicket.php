<?php

namespace App\Http\Livewire\Site\Dashboard\Tickets;

use App\Http\Livewire\BaseComponent;
use App\Models\Setting;
use App\Models\Ticket;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\WithFileUploads;

class StoreTicket extends BaseComponent
{
    use WithFileUploads;
    public $address;
    public $ticket , $user , $header , $mode , $disabled = false , $data = [];
    public $subject , $content , $file = [] , $files, $priority , $status    , $newFile , $newMessage;
    public function mount($action , $id=null)
    {
        SEOMeta::setTitle('حساب کاربری-پشتیبانی',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('حساب کاربری-پشتیبانی');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('حساب کاربری-پشتیبانی');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('حساب کاربری-پشتیبانی');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
        if ($action == 'edit') {
            $this->user = auth()->user();
            $this->ticket = $this->user->tickets()->with(['child'])->findOrFail($id);
            $this->header = $this->ticket->subject;
            $this->subject = $this->ticket->subject;
            $this->content = $this->ticket->content;
            $this->files = $this->ticket->file;
            $this->priority = $this->ticket->priority;
            $this->disabled = true;
            $this->address = [
                'home' => ['link' => route('home') , 'label' => 'خانه'],
                'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
                'tickets' => ['link' => route('user.tickets') , 'label' => 'پشتیبانی'],
                'ticket' => ['link' => '' ,'label' => $this->ticket->subject],
            ];
        } elseif ($action == 'create') {
            $this->address = [
                'home' => ['link' => route('home') , 'label' => 'خانه'],
                'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
                'tickets' => ['link' => route('user.tickets') , 'label' => 'پشتیبانی'],
                'ticket' => ['link' => '' , 'label' => 'درخواست جدید'],
            ];
        } else abort(404);

        $this->mode = $action;
        $this->data['subject'] = Setting::getSingleRow('subject',[]);
        $this->data['priority'] = Ticket::getPriority();
    }


    public function store()
    {
        $rateKey = 'ticket:' . auth()->user()->user_name . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($rateKey,365)) {
            $this->reset(['subject','content','file']);
            return $this->addError('error', 'زیادی تلاش کردید. لطفا پس از مدتی دوباره تلاش کنید.');
        }

        RateLimiter::hit($rateKey, 24 * 60 * 60);
        if ($this->mode == 'edit')
            $this->saveInDataBase($this->ticket);
        elseif ($this->mode == 'create')
        {
            $this->saveInDataBase(new Ticket());
//            $this->reset(['subject','content','file','priority','final_message','newMessage']);

        } else abort(404);
    }

    public function saveInDataBase(Ticket $model)
    {
        $this->resetErrorBag();
        if ($this->mode == 'create')
        {
            $this->validate([
                'subject' => ['required','string','max:250'],
                'content' => ['required','string','max:18500'],
                'file' => ['array','min:0','max:5'],
                'file.*' => ['nullable','mimes:png,PNG,JPG,jpg,JPEG,jpeg','max:2048'],
                'priority' => ['in:'.Ticket::HIGH.','.Ticket::NORMAL.','.Ticket::HIGH],
            ],[],[
                'subject' => 'موضوع',
                'content' => 'متن درخواست',
                'file' => 'فایل',
                'priority' => 'الویت',
            ]);
            $this->uploadFile();
            $model->subject = $this->subject;
            $model->user_id  = auth()->id();
            $model->content = $this->content;
            $model->sender_id  = auth()->id();
            $model->priority  = $this->priority;
            $model->status = Ticket::PENDING;
            $model->sender_type = Ticket::USER;

            if (!is_null($this->file) && !empty($this->file)){
                $images = [];
                foreach ($this->file as $item){
                    if (!is_null($item) && !empty($item)){
                        $pic = 'storage/'.$item->store('files/ticket', 'public');
                        array_push($images,$pic);
                    }
                }
                $model->file = implode(',',$images);
            }
            $model->save();
            $this->emitNotify('اطلاعات با موفقیت ثبت شد');
            redirect()->route('user.ticket',['edit',$model->id]);

        }
        elseif ($this->mode == 'edit')
        {
            if ($model->status == Ticket::ANSWERED) {
                $this->validate([
                    'newMessage' => ['required','string','max:250'],
                    'newFile' => ['array','min:0','max:5'],
                    'newFile.*' => ['nullable','mimes:png,PNG,JPG,jpg,JPEG,jpeg','max:2048'],
                ],[],[
                    'newMessage' => 'متن درخواست',
                    'newFile' =>  'فایل',
                ]);
                $ticket = new Ticket();
                $ticket->subject = $model->subject;
                $ticket->user_id  = auth()->id();
                $ticket->content = $this->newMessage;
                $ticket->parent_id = $model->id;
                $ticket->sender_id = auth()->id();
                $ticket->priority = $model->priority;
                $ticket->sender_type = Ticket::USER;
                $ticket->status = $model->status;
                if (!is_null($this->newFile) && !empty($this->newFile)){
                    $images = [];
                    foreach ($this->newFile as $item){
                        if (!is_null($item) && !empty($item)){
                            $pic = 'storage/'.$item->store('files/ticket', 'public');
                            array_push($images,$pic);
                        }
                    }
                    $ticket->file = implode(',',$images);
                }
                $ticket->save();
                $this->emitNotify('اطلاعات با موفقیت ثبت شد');
                $this->ticket->child->push($ticket);
                $model->status  = Ticket::USER_ANSWERED;
                $model->save();
                $this->reset(['newMessage','newFile']);
            } else {
                $this->emitNotify('لطفا تا ارسال پاسخ توسط مدیریت منتظر بمانید','warning');
                return;
            }

        }
    }

    public function uploadFile()
    {
        // upon form submit, this function till fill your progress bar
    }

    public function render()
    {
        return view('livewire.site.dashboard.tickets.store-ticket')
            ->extends('livewire.site.layouts.site.site');
    }
}
