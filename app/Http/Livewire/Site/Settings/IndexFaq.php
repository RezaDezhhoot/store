<?php

namespace App\Http\Livewire\Site\Settings;

use App\Http\Livewire\BaseComponent;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class IndexFaq extends BaseComponent
{
    public $data = [] , $address;
    public function mount()
    {
        SEOMeta::setTitle('سوالات متداول',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('سوالات متداول');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('سوالات متداول');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('سوالات متداول');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
    }

    public function render()
    {
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'faq' => ['link' => '' , 'label' => 'سوالات متداول']
        ];
        $this->data['faq'] = Setting::where('name','faq')->get();

        return view('livewire.site.settings.index-faq')
            ->extends('livewire.site.layouts.site.site');
    }
}
