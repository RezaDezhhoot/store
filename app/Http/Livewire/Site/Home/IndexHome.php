<?php

namespace App\Http\Livewire\Site\Home;

use App\Http\Livewire\BaseComponent;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use App\Models\Setting;

class IndexHome extends BaseComponent
{
    public $content , $funFacts = [] , $data;
    public function mount()
    {
        SEOMeta::setTitle(Setting::getSingleRow('title'),false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle(Setting::getSingleRow('title'));
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle(Setting::getSingleRow('title'));
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle(Setting::getSingleRow('title'));
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
        $this->data['homeSlider'] = Setting::getSingleRow('homeSlider',[]);
        $content = Setting::getSingleRow('homeContent',[]);
        $send = [];
        $i = 0;
        foreach ($content as $key => $value)
        {
            if ($value['category'] <> 'banners')
            {
                $model = Setting::models()[$value['category']];
                $send[$i] = $value;
                $send[$i]['content'] = $model::findMany($value['contentCase']);

            } else
                $send[$i] = $value;
            $i++;
        }
        $this->content = collect($send)->sortBy('view');
    }
    public function render()
    {
        return view('livewire.site.home.index-home')
            ->extends('livewire.site.layouts.site.site');
    }
}
