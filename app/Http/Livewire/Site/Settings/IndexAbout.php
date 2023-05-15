<?php

namespace App\Http\Livewire\Site\Settings;

use App\Http\Livewire\BaseComponent;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class IndexAbout extends BaseComponent
{
    public $data = [] , $address;
    public function mount()
    {
        SEOMeta::setTitle('درباره ما',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('درباره ما');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('درباره ما');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('دربار ما');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
    }

    public function render()
    {
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'about' => ['link' => '' , 'label' => 'درباره ما']
        ];
        $this->data = [
            'aboutUs' => Setting::getSingleRow('aboutUs'),
            'aboutUsImages' => Setting::getSingleRow('aboutUsImages'),
        ];
        return view('livewire.site.settings.index-about')
            ->extends('livewire.site.layouts.site.site');
    }
}
