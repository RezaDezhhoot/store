<?php

namespace App\Http\Livewire\Site\Settings;

use App\Http\Livewire\BaseComponent;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class IndexContact extends BaseComponent
{
    public $data = [] , $address;

    public function mount()
    {
        SEOMeta::setTitle('ارتباط با ما',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('ارتباط با ما');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('ارتباط با ما');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('ارتباط با ما');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
    }

    public function render()
    {
        $this->data = [
            'googleMap' => Setting::getSingleRow('googleMap'),
            'contactText' => Setting::getSingleRow('contactText'),
            'tel' => Setting::getSingleRow('tel'),
            'email' => Setting::getSingleRow('email'),
            'address' => Setting::getSingleRow('address'),
            'office' => Setting::getSingleRow('office')
        ];
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'contact' => ['link' => '' , 'label' => 'تماس با ما']
        ];
        return view('livewire.site.settings.index-contact')
            ->extends('livewire.site.layouts.site.site');
    }
}
