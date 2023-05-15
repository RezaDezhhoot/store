<?php

namespace App\Http\Livewire\Site\Dashboard\Returns;

use App\Http\Livewire\BaseComponent;
use App\Models\Refund;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Livewire\WithPagination;

class IndexReturn extends BaseComponent
{
    use WithPagination;
    public $address ;

    public function mount()
    {
        SEOMeta::setTitle('حساب کاربری-مرجوعی ها',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('حساب کاربری-مرجوعی ها');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('حساب کاربری-مرجوعی ها');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('حساب کاربری-مرجوعی ها');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
            'returns' => ['link' => '' , 'label' => 'مرجوعی ها'],
        ];
    }

    public function render()
    {
        $returns = Refund::latest('id')->with(['order'])->whereHas('order',function ($query){
            return $query->whereHas('order',function ($query){
                return $query->where('user_id',auth()->id());
            });
        })->paginate(6);
        return view('livewire.site.dashboard.returns.index-return',['returns'=>$returns])
            ->extends('livewire.site.layouts.site.site');
    }
}
