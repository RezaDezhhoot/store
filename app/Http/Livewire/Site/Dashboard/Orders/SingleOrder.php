<?php

namespace App\Http\Livewire\Site\Dashboard\Orders;

use App\Http\Livewire\BaseComponent;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use App\Models\Comment;

class SingleOrder extends BaseComponent
{
    public $address , $order ,$details , $data = [] , $commentText = [] ;
    public  $canComment;
    public function mount($id)
    {
        $this->order = Order::where( 'user_id' , auth()->id())->findOrFail($id);
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
            'orders' => ['link' => route('user.orders') , 'label' => 'سفارش ها'],
            'order' => ['link' => '' , 'label' => 'سفارش '.$this->order->tracking_code],
        ];
        $this->data['status'] = Order::getStatus();
        $this->canComment = $this->order->canComment();
        $this->details = $this->order->details;
    }
    public function render()
    {
        return view('livewire.site.dashboard.orders.single-order')
            ->extends('livewire.site.layouts.site.site');
    }

    public function storeComment()
    {
        if ($this->canComment){
            foreach ($this->commentText as $id => $text){
                $order = OrderDetail::find($id);
                $comment = Comment::where('order_id',$id)->first();
                $this->validate([
                    'commentText.'.$id => ['required','string','max:250']
                ],[],[
                    'commentText.'.$id => 'متن نظر'
                ]);
                if (is_null($comment)  && $order->status == Order::STATUS_COMPLETED ){
                    Comment::create([
                        'comment' => $text,
                        'rating'=> 2,
                        'status' => Comment::NEW,
                        'commentable_type' => Comment::PRODUCT,
                        'commentable_id' => $order->product_id,
                        'order_id' => $id,
                        'user_id' => auth()->id(),
                    ]);
                    $this->commentText[$id] = 'نظر شما با موفقیت ثبت شد با تشکر از نظر شما.';
                    $this->canComment = Order::find($order->order_id)->canComment();
                }
            }
        }
    }
}
