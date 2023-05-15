<?php

namespace App\Http\Livewire\Admin\Profile;

use App\Http\Livewire\BaseComponent;
use App\Models\Setting;
use App\Models\User;
use App\Traits\Admin\ChatList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class IndexProfile extends BaseComponent
{
    use WithFileUploads ;
    public $user , $header , $role;
    public $name  , $user_name  , $phone  , $password ;
    public function mount()
    {
        $this->user = User::findOrFail(Auth::id());
        $this->header = $this->user->user_name;
        $this->name = $this->user->name;
        $this->user_name = $this->user->user_name;
        $this->phone = $this->user->phone;
    }
    public function render()
    {
        return view('livewire.admin.profile.index-profile')->extends('livewire.admin.layouts.admin');
    }

    public function store()
    {
        $fields = [
            'name' => ['required', 'string','max:150'],
            'user_name' => ['required', 'string' ,'max:150' ,'unique:users,user_name,'. ($this->user->id ?? 0)],
            'phone' => ['required','size:11' , 'unique:users,phone,'. ($this->user->id ?? 0)],
        ];
        $messages = [
            'name' => 'نام ',
            'user_name' => 'نام کربری',
            'phone' => 'شماره همراه',
        ];
        if (isset($this->pass_word))
        {
            $fields['password'] = ['required','min:'.Setting::getSingleRow('password_length'),'regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9]).*$/'];
            $messages['password'] = 'گذرواژه';
        }
        $this->validate($fields,[],$messages);

        $this->user->name = $this->name;
        $this->user->user_name = $this->user_name;
        $this->user->phone = $this->phone;
        if (isset($this->password))
            $this->user->password = $this->password;
        $this->user->save();
        $this->emitNotify('اطلاعات با موفقیت ثبت شد');
    }


}
