<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Http\Livewire\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Setting;

class ContactSetting extends BaseComponent
{
    use AuthorizesRequests;

    public $header , $googleMap  , $contactText;

    public function mount()
    {
        $this->authorize('show_settings_contactUs');
        $this->header = 'تنظیمات ارتباط با ما';
        $this->googleMap = Setting::getSingleRow('googleMap');
        $this->contactText = Setting::getSingleRow('contactText');
    }

    public function render()
    {
        return view('livewire.admin.settings.contact-setting')
            ->extends('livewire.admin.layouts.admin');
    }

    public function store()
    {
        $this->authorize('edit_settings_contactUs');
        $this->validate(
            [
                'googleMap' => ['nullable', 'string','max:10000'],
                'contactText' => ['nullable','string','max:10000'],
            ] , [] , [
                'googleMap' => 'شناسه گوگل مپ',
                'contactText' => 'متن',
            ]
        );
        Setting::updateOrCreate(['name' => 'googleMap'], ['value' => $this->googleMap]);
        Setting::updateOrCreate(['name' => 'contactText'], ['value' => $this->contactText]);
        $this->emitNotify('اطلاعات با موفقیت ثبت شد');
    }
}
