<?php

namespace App\Http\Livewire\Site\Dashboard\Dashboard;

use App\Http\Livewire\BaseComponent;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Livewire\WithPagination;


class IndexDashboard extends BaseComponent
{
    use WithPagination;
    public $address ;

    public function mount()
    {
        SEOMeta::setTitle('حساب کاربری',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('حساب کاربری');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('حساب کاربری');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('حساب کاربری');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
            'dashboard' => ['link' => '' , 'label' => 'داشبورد'],
        ];
    }

    public function render()
    {
        $transactions = auth()->user()->walletTransactions()->latest('id')->where('confirmed', 1)->paginate(8);

        return view('livewire.site.dashboard.dashboard.index-dashboard',['transactions'=>$transactions])
            ->extends('livewire.site.layouts.site.site');
    }
}
