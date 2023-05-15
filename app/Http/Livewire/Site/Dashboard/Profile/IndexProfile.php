<?php

namespace App\Http\Livewire\Site\Dashboard\Profile;

use App\Http\Livewire\BaseComponent;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Hash;


class IndexProfile extends BaseComponent
{
    public $address , $name , $user_name , $password , $password_confirmation , $user;

    public function mount()
    {
        SEOMeta::setTitle('حساب کاربری-جزئیات حساب',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('حساب کاربری-جزئیات حساب');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('حساب کاربری-جزئیات حساب');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('حساب کاربری-جزئیات حساب');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
            'profile' => ['link' => '' , 'label' => 'جزئیات حساب'],
        ];
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->user_name = $this->user->user_name;
    }

    public function store()
    {
        $fields = [
            'name' => ['required','string','max:120'],
            'user_name' => ['required','string','max:80','unique:users,user_name,'.auth()->id()],
        ];
        $messages = [
            'name' => 'نام کامل',
            'user_name' => 'نام کربری',
        ];
        if (isset($this->password))
        {
            $fields['password'] = ['required','min:6','regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9]).*$/','confirmed'];
            $messages['password'] = 'گذرواژه';
        }

        $this->validate($fields,[],$messages);

        $this->user->name = $this->name;
        $this->user->user_name = $this->user_name;
        if (isset($this->password))
            $this->user->password = $this->password;

        $this->user->save();
        $this->emitNotify('اطلاعات با موفقیت ذخیره شد');
    }

    public function render()
    {
        return view('livewire.site.dashboard.profile.index-profile')
            ->extends('livewire.site.layouts.site.site');
    }
}
