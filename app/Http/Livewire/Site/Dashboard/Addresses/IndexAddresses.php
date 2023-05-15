<?php

namespace App\Http\Livewire\Site\Dashboard\Addresses;

use App\Http\Livewire\BaseComponent;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Livewire\WithPagination;
use App\Models\Address;
class IndexAddresses extends BaseComponent
{
    use WithPagination;
    public $address ;

    public function mount()
    {
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
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
            'addresses' => ['link' => '' , 'label' => 'ادرس ها'],
        ];
    }

    public function render()
    {
        $addresses = Address::where([
            ['user_id',auth()->id()],
            ['status',Address::CONFIRMED]
        ])->orderBy('active','desc')->paginate(6);
        return view('livewire.site.dashboard.addresses.index-addresses',['addresses'=>$addresses])
            ->extends('livewire.site.layouts.site.site');
    }

    public function delete($id)
    {
        Address::where('user_id',auth()->id())->findOrFail($id)->delete();
    }

    public function setDefault($id)
    {
        $addresses = Address::where('user_id',auth()->id())->get();
        foreach ($addresses as $address)
        {
            $address->active = false;
            $address->save();
        }

        Address::findOrFail($id)->update([
            'active' => true
        ]);
        $this->emitNotify('ادرس با موفقیت ثبت شد');
    }
}
