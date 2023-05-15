<?php

namespace App\Http\Livewire\Site\Dashboard\Orders;

use App\Http\Livewire\BaseComponent;
use App\Models\Order;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Livewire\WithPagination;

class IndexOrders extends BaseComponent
{
    use WithPagination;
    public $address ;

    public function mount()
    {
        SEOMeta::setTitle('حساب کاربری-سفارش های من',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('حساب کاربری-سفارش های من');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('حساب کاربری-سفارش های من');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('حساب کاربری-سفارش های من');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
            'orders' => ['link' => '' , 'label' => 'سفارش ها'],
        ];
    }
    public function render()
    {
        $orders = Order::latest('id')->paginate(10);
        return view('livewire.site.dashboard.orders.index-orders',['orders'=>$orders])
            ->extends('livewire.site.layouts.site.site');
    }
}
