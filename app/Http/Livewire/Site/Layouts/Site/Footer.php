<?php

namespace App\Http\Livewire\Site\Layouts\Site;

use App\Http\Livewire\BaseComponent;
use App\Models\Newspaper;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class Footer extends BaseComponent
{
    public $data = [], $email;
    public function render()
    {
        $this->data['tel'] = Setting::getSingleRow('tel');
        $this->data['email'] = Setting::getSingleRow('email');
        $this->data['address'] = Setting::getSingleRow('address');
        $this->data['logo'] = Setting::getSingleRow('logo');
        $this->data['miniAbout'] = Setting::getSingleRow('miniAbout');
        $this->data['copyRight'] = Setting::getSingleRow('copyRight');
        $this->data['contact'] = Setting::getSingleRow('contact',[]);
        return view('livewire.site.layouts.site.footer');
    }

    public function registerEmail()
    {
        if (auth()->check()) {
            $rateKey = 'verify-attempt:' . Auth::user()->user_name . '|' . request()->ip();
            if (RateLimiter::tooManyAttempts($rateKey, 5)) {
                $this->reset(['email']);
                return $this->addError('email', 'زیادی تلاش کردید. لطفا پس از مدتی دوباره تلاش کنید.');
            }

            RateLimiter::hit($rateKey, 12 * 60 * 60);
            $this->validate([
                'email' => ['required','unique:news,email','email']
            ],[],[
                'email' => 'ادرس ایمیل',
            ]);
            $news = new Newspaper();
            $news->email = $this->email;
            $news->save();
            $this->reset(['email']);
            $this->addError('email','ادرس ایمیل با موفیت ثبت شد.');
        } else {
            $this->addError('email','متاسفانه شما هنوز ثبت نام نکرده اید.');
        }
    }
}
