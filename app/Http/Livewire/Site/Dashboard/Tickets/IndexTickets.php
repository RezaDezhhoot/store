<?php

namespace App\Http\Livewire\Site\Dashboard\Tickets;

use App\Http\Livewire\BaseComponent;
use App\Models\Setting;
use App\Models\User;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Livewire\Component;
use Livewire\WithPagination;

class IndexTickets extends BaseComponent
{
    public $address;
    use WithPagination;
    public $paginate = 10;

    public function mount()
    {
        SEOMeta::setTitle('حساب کاربری-پشتیبانی',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('حساب کاربری-پشتیبانی');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('حساب کاربری-پشتیبانی');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('حساب کاربری-پشتیبانی');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
            'tickets' => ['link' => '' , 'label' => 'پشتیبانی'],
        ];
    }

    public function render()
    {
        $user = User::findOrFail(auth()->id());
        $tickets = $user->tickets()->whereNull('parent_id')->orderBy('id','desc')->paginate($this->paginate);
        return view('livewire.site.dashboard.tickets.index-tickets',['tickets' => $tickets])
            ->extends('livewire.site.layouts.site.site');
    }
}
