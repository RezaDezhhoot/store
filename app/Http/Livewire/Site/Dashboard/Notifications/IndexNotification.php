<?php

namespace App\Http\Livewire\Site\Dashboard\Notifications;

use App\Http\Livewire\BaseComponent;
use App\Models\Notification;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Livewire\WithPagination;

class IndexNotification extends BaseComponent
{
    use WithPagination;
    public $address ;

    public function mount()
    {
        SEOMeta::setTitle('حساب کاربری-اعلان ها',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('حساب کاربری-اعلان ها');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('حساب کاربری-اعلان ها');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('حساب کاربری-اعلان ها');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
            'notifications' => ['link' => '' , 'label' => 'اعلان ها'],
        ];
    }

    public function render()
    {
        $notifications = Notification::latest('id')->where('user_id',auth()->id())->paginate(6);
        return view('livewire.site.dashboard.notifications.index-notification',['notifications'=>$notifications])
            ->extends('livewire.site.layouts.site.site');
    }
}
