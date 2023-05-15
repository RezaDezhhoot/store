<?php

namespace App\Http\Livewire\Site\Dashboard\Addresses;

use App\Http\Livewire\BaseComponent;
use App\Models\Address;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class StoreAddress extends BaseComponent
{
    public $address , $single_address , $data = [] , $mode;
    public $province , $city , $fullAddress , $postal_code , $name , $phone , $active = false;
    public function mount($action , $id = null)
    {
        if ($action == 'edit'){
            $this->single_address = Address::where([
                ['user_id',auth()->id()],
                ['status',Address::CONFIRMED],
            ])->findOrFail($id);
            $this->address = [
                'home' => ['link' => route('home') , 'label' => 'خانه'],
                'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
                'addresses' => ['link' => route('user.addresses') , 'label' => 'ادرس ها'],
                'address' => ['link' => '' , 'label' => $this->single_address->address]
            ];
            $this->province = $this->single_address->province;
            $this->city = $this->single_address->city;
            $this->fullAddress = $this->single_address->address;
            $this->postal_code = $this->single_address->postal_code;
            $this->name = $this->single_address->name;
            $this->phone = $this->single_address->phone;
            $this->active = $this->single_address->active ?? false;
        } elseif ($action == 'create') {
            $this->address = [
                'home' => ['link' => route('home') , 'label' => 'خانه'],
                'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
                'addresses' => ['link' => route('user.addresses') , 'label' => 'ادرس ها'],
                'address' => ['link' => '' , 'label' => 'ادرس جدید']
            ];
            $this->name = auth()->user()->name;
            $this->phone = auth()->user()->phone;
        } else abort(404);
        SEOMeta::setTitle('حساب کاربری-ادرس ها',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('حساب کاربری-ادرس ها');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('حساب کاربری-ادرس ها');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('حساب کاربری-ادرس ها');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
        $this->data['province'] = Setting::getProvince();
        $this->mode = $action;
    }


    public function store()
    {
        if ($this->mode == 'edit')
            $this->saveInDataBase($this->single_address);
        elseif ($this->mode == 'create')
        {
            $this->saveInDataBase(new Address());
            $this->reset(['province','city','fullAddress','name','phone','active','postal_code']);
            $this->name = auth()->user()->name;
            $this->phone = auth()->user()->phone;
        }
    }

    public function saveInDataBase(Address $address)
    {
        $this->validate([
            'province'=> ['required','in:'.implode(',',array_keys($this->data['province']))],
            'city' => ['required','in:'.implode(',',array_keys($this->data['city']))],
            'fullAddress' => ['required','string','max:250'],
            'postal_code' => ['required','string','size:10'],
            'name' => ['required','string','max:70'],
            'phone' => ['required','string','size:11'],
            'active' => ['boolean']
        ],[],[
            'province' => 'استان',
            'city' => 'شهر',
            'fullAddress' => 'ادرس',
            'postal_code' => 'کد پستی',
            'name' => 'نام کامل',
            'phone' => 'شماره همراه',
            'active' => 'تنظیم به عنوان ادرس پیشفرض'
        ]);


        if ($this->active)
            foreach (auth()->user()->addresses as $item)
                $item->update(['active' => false]);


        $address->country = 'Iran';
        $address->province = $this->province;
        $address->city = $this->city;
        $address->address = $this->fullAddress;
        $address->postal_code = $this->postal_code;
        $address->name = $this->name;
        $address->phone = $this->phone;
        $address->active = $this->active;
        $address->user_id = auth()->id();
        $address->status = Address::CONFIRMED;
        $address->save();




        $this->emitNotify('اطلاعات با موفقیت ذخیره شده');
    }

    public function render()
    {
        if (isset($this->province))
            $this->data['city'] = Setting::getCity()[$this->province];
        else
            $this->data['city'] = [];

        return view('livewire.site.dashboard.addresses.store-address')
            ->extends('livewire.site.layouts.site.site');
    }
}
