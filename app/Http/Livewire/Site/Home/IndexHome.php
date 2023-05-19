<?php

namespace App\Http\Livewire\Site\Home;

use App\Http\Livewire\BaseComponent;
use App\Models\Article;
use App\Models\Product;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use App\Models\Setting;

class IndexHome extends BaseComponent
{
    public $content , $funFacts = [] , $data , $about , $articles = [] , $products;
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
        $this->about = Setting::getSingleRow('homeAbout');
        $this->data['img1'] = Setting::getSingleRow('homeImg1');
        $this->data['img2'] = Setting::getSingleRow('homeImg2');
        $this->data['img3'] = Setting::getSingleRow('homeImg3');
        $send = [];
        $this->articles = Article::query()->latest()->published()->take(4)->get();
        $this->products = Product::query()->latest()->get();
        $i = 0;
//        foreach ($content as $key => $value)
//        {
//            if ($value['category'] <> 'banners')
//            {
//                $model = Setting::models()[$value['category']];
//                $send[$i] = $value;
//                $send[$i]['content'] = $model::findMany($value['contentCase']);
//
//            } else
//                $send[$i] = $value;
//            $i++;
//        }
//        $this->content = collect($send)->sortBy('view');
    }
    public function render()
    {
        return view('livewire.site.home.index-home')
            ->extends('livewire.site.layouts.site.site');
    }
}
