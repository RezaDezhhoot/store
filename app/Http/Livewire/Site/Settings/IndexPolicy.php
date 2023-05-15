<?php

namespace App\Http\Livewire\Site\Settings;

use App\Http\Livewire\BaseComponent;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;


class IndexPolicy extends BaseComponent
{
    public $data = [] , $address;
    public function mount()
    {
        SEOMeta::setTitle('سیاست حریم خصوصی',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('سیاست حریم خصوصی');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('سیاست حریم خصوصی');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('سیاست حریم خصوصی');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
    }
    public function render()
    {
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'policy' => ['link' => '' , 'label' => 'سیاست حریم خصوصی']
        ];

        $this->data = [
            'policy' => Setting::getSingleRow('policy'),
        ];
        return view('livewire.site.settings.index-policy')
            ->extends('livewire.site.layouts.site.site');
    }
}
