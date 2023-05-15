<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Http\Livewire\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Setting;

class BaseSetting extends BaseComponent
{
    use AuthorizesRequests;

    public $header , $name , $logo , $status , $title  , $copyRight , $subject = [] ,$logInImage , $contact = [] , $waterMark;
    public  $data = [] , $i = 1 , $registerGift , $notification  , $tel , $email, $address, $seoDescription , $seoKeyword ;
    public   $google , $password_length , $dos_count  , $valid_ticket_files  , $ticket_per_day , $miniAbout , $policy;
    public function mount()
    {
        $this->authorize('show_settings_base');
        $this->header = 'تنظیمات پایه';
        $this->data['status'] = ['0' => 'بسته','1' => 'باز'];
        $this->contact = Setting::getSingleRow('contact',[]);
        $this->subject = Setting::getSingleRow('subject',[]);
        $this->copyRight = Setting::getSingleRow('copyRight');
        $this->status = Setting::getSingleRow('status');
        $this->logo = Setting::getSingleRow('logo');
        $this->waterMark = Setting::getSingleRow('waterMark');
        $this->title = Setting::getSingleRow('title');
        $this->name = Setting::getSingleRow('name');
        $this->registerGift = Setting::getSingleRow('registerGift');
        $this->notification = Setting::getSingleRow('notification');
        $this->tel = Setting::getSingleRow('tel');
        $this->email = Setting::getSingleRow('email');
        $this->address = Setting::getSingleRow('address');
        $this->seoDescription = Setting::getSingleRow('seoDescription');
        $this->seoKeyword = Setting::getSingleRow('seoKeyword');
        $this->logInImage = Setting::getSingleRow('logInImage');
        $this->password_length = Setting::getSingleRow('password_length');
        $this->dos_count = Setting::getSingleRow('dos_count');
        $this->valid_ticket_files = Setting::getSingleRow('valid_ticket_files');
        $this->ticket_per_day = Setting::getSingleRow('ticket_per_day');
        $this->miniAbout = Setting::getSingleRow('miniAbout');
        $this->policy = Setting::getSingleRow('policy');
    }

    public function render()
    {
        return view('livewire.admin.settings.base-setting')
            ->extends('livewire.admin.layouts.admin');
    }

    public function addSubject()
    {
        $this->i = $this->i+ 1;
        array_push($this->subject,'');
    }

    public function store()
    {
        $this->authorize('edit_settings_base');
        $this->validate(
            [
                'name' => ['required', 'string','max:50'],
                'title' => ['required','string','max:50'],
                'logo' => ['required','required','max:250'],
                'waterMark' => ['required','required','max:250'],
                'status' => ['required','string','in:1,0'],
                'registerGift' => ['nullable','numeric','between:0,99999999999.999999'],
                'notification' => ['nullable','string','max:250'],
                'tel' => ['required','string','max:30'],
                'address' => ['nullable','string','max:300'],
                'email' => ['required','email','max:50'],
                'subject' => ['nullable','array'],
                'subject.*' => ['required','string','max:50'],
                'seoDescription' => ['required','string','max:850'],
                'seoKeyword' => ['required','string','max:850'],
                'logInImage' => ['required','string','max:250'],
                'contact' => ['nullable','array'],
                'contact.*.img' => ['required','max:50','string'],
                'contact.*.link' => ['required','max:250','url'],
                'miniAbout' => ['nullable','string','max:350'],
                'policy' => ['nullable','string','max:60000'],
                'password_length' => ['required','integer','min:5'],
                'dos_count' => ['required','integer','min:3'],
            ] , [] , [
                'name' => 'نام سایت',
                'title' => 'عنوان سایت',
                'logo' => 'لوکو سایت',
                'waterMark' => 'تصویر واتر مارک',
                'status' => 'وضعیت سایت',
                'registerGift' => 'هدیه ثبت نام',
                'notification' => 'اعلان بالا صفحه',
                'tel' => 'تلفن',
                'address' => 'ادرس',
                'email' => 'ایمیل',
                'subject' => 'موضوع ها',
                'seoDescription' => 'توضیحات سئو',
                'seoKeyword' => 'کلمات سئو',
                'logInImage' => 'تصویر صفحه ورود',
                'contact' => 'لینک های ارتباطی',
                'miniAbout' => 'متن معرفی',
                'policy' => 'سیاست حریم خصوصی',
                'password_length' => 'حداقل طول پسورد',
                'dos_count' => 'حداکثر امکان برای درخواست های پیوسته سمت سرور',
            ]
        );
        Setting::updateOrCreate(['name' => 'subject'], ['value' => json_encode($this->subject)]);
        Setting::updateOrCreate(['name' => 'copyRight'], ['value' => $this->copyRight]);
        Setting::updateOrCreate(['name' => 'status'], ['value' => $this->status]);
        Setting::updateOrCreate(['name' => 'logo'], ['value' => $this->logo]);
        Setting::updateOrCreate(['name' => 'waterMark'], ['value' => $this->waterMark]);
        Setting::updateOrCreate(['name' => 'title'], ['value' => $this->title]);
        Setting::updateOrCreate(['name' => 'name'], ['value' => $this->name]);
        Setting::updateOrCreate(['name' => 'notification'], ['value' => $this->notification]);
        Setting::updateOrCreate(['name' => 'tel'], ['value' => $this->tel]);
        Setting::updateOrCreate(['name' => 'email'], ['value' => $this->email]);
        Setting::updateOrCreate(['name' => 'address'], ['value' => $this->address]);
        Setting::updateOrCreate(['name' => 'seoDescription'], ['value' => $this->seoDescription]);
        Setting::updateOrCreate(['name' => 'seoKeyword'], ['value' => $this->seoKeyword]);
        Setting::updateOrCreate(['name' => 'logInImage'], ['value' => $this->logInImage]);
        Setting::updateOrCreate(['name' => 'registerGift'], ['value' => $this->registerGift]);
        Setting::updateOrCreate(['name' => 'contact'], ['value' => json_encode($this->contact)]);
        Setting::updateOrCreate(['name' => 'password_length'], ['value' => $this->password_length]);
        Setting::updateOrCreate(['name' => 'dos_count'], ['value' => $this->dos_count]);
        Setting::updateOrCreate(['name' => 'miniAbout'], ['value' => $this->miniAbout]);
        Setting::updateOrCreate(['name' => 'policy'], ['value' => $this->policy]);
        $this->emitNotify('اطلاعات با موفقیت ثبت شد');
    }

    public function deleteSubject($key)
    {
        unset($this->subject[$key]);
    }
    public function addLink()
    {
        $this->i = $this->i+ 1;
        array_push($this->contact,'');
    }

    public function delete($key)
    {
        unset($this->contact[$key]);
    }
}
