<?php

namespace App\Http\Livewire\Site\Dashboard\Returns;

use App\Http\Livewire\BaseComponent;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Refund;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Carbon\Carbon;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class StoreReturn extends BaseComponent
{
    use WithPagination , WithFileUploads;
    public $address  , $return , $mode , $order_id , $content , $images , $card_number , $sheba_number , $name , $quantity = 1;
    public $data = [] , $orderBasket , $file , $result;
    public function mount($action , $id =null)
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


        if ($action == 'edit') {
            $this->return = Refund::findOrFail($id);
            $this->order_id = $this->return->order_id;
            $this->orderBasket = $this->return->order->order;
            $this->content = $this->return->content;
            $this->images = $this->return->images;
            $this->card_number = $this->return->card_number;
            $this->sheba_number = $this->return->sheba_number;
            $this->name = $this->return->name;
            $this->quantity = $this->return->quantity;
            $this->orderBasket = $this->return->order->order->id;
            $this->result = $this->return->result;
            $this->address = [
                'home' => ['link' => route('home') , 'label' => 'خانه'],
                'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
                'returns' => ['link' => route('user.returns') , 'label' => 'مرجوعی ها'],
                'return' => ['link' => '' , 'label' => $this->return->order->tracking_code],
            ];

        } elseif ($action == 'create') {
            $this->name = auth()->user()->name;
            $this->address = [
                'home' => ['link' => route('home') , 'label' => 'خانه'],
                'client' => ['link' => route('user.dashboard') , 'label' => 'حساب کاربری'],
                'returns' => ['link' => '' , 'label' => 'مرجوعی ها'],
            ];
        } else abort(404);

        $orders = auth()->user()->orders()->with(['details'])->get();
        $now = Carbon::make(now());
        foreach ($orders as $order) {
            foreach ($order->details as $detail) {
                if (!is_null($detail->created_at)) {
                    $max = Carbon::make($detail->created_at)->addDays($detail->product->guarantee);
                    if ($now->diff($max)->format("%r%a") > 0 && $detail->status <> Order::STATUS_NOT_PAID) {
                        $this->data['orders_details'][$order->id][$detail->id] = '('.$detail->product->title.')'.' * '.$detail->quantity;
                        $this->data['orders'][$order->id] = $order->tracking_code;
                    }
                }
            }
        }
        $this->mode = $action;
    }


    public function store()
    {
        if ($this->mode == 'create')
        {
            $this->uploadFile();
            $this->saveInDataBase(new Refund());
        } else {
            $this->emitNotify('برای این درخواست امکان ویرایش وجود ندارد','warning');
        }
    }

    public function saveInDataBase(Refund $refund)
    {

        if (isset($this->order_id)){
            $order = OrderDetail::find($this->order_id);
            if ($order->order->user_id != auth()->id() ) {
                $this->emitNotify('برای این سفارش امکان درخواست وجود ندارد','warning');
                return;
            }
        } else {
            $this->addError('order_id',__('validation.required', ['attribute' => '']));
            return;
        }
        $fields = [
            'orderBasket' => ['required','exists:orders,id'],
            'order_id' => ['required','exists:order_details,id','unique:refunds,order_id'],
            'content'=> ['required','string','max:2500'],
            'file'=>['array','min:1','max:4'],
            'file.*' => ['nullable','image','mimes:png,PNG,JPG,jpg,JPEG,jpeg','max:2048'],
            'card_number' => ['required','size:16','string'],
            'sheba_number' => ['required','size:26','string'],
            'name' => ['required','string','max:120'],
        ];
        $fields['quantity'] = ['required','min:1','integer','max:'.$order->quantity];
        $messages = [
            'orderBasket' => 'سبد سفارش',
            'order_id' => 'محصول',
            'content'=> 'توضیحات',
            'file'=> 'تصاویر',
            'file.*' => 'تصاویر',
            'card_number' => 'شماره کارت',
            'sheba_number' => 'شماره شبا',
            'name' => 'نام',
            'quantity' => 'تعداد'
        ];
        $this->validate($fields,[],$messages);
        $order = OrderDetail::find($this->order_id);
        if ($order->order->user_id != auth()->id() ) {
            $this->emitNotify('برای این سفارش امکان درخواست وجود ندارد','warning');
            return;
        }

        if (!is_null($this->file)) {
            $images = [];
            foreach ($this->file as $image) {
                if (!is_null($image) && !empty($image)){
                    $pic = 'storage/'.$image->store('files/returns', 'public');
                    array_push($images,$pic);
                }
            }
            $refund->images = implode(',',$images);
        }
        $refund->order_id = $this->order_id;
        $refund->content = $this->content;
        $refund->status = Refund::NEW;
        $refund->card_number = $this->card_number;
        $refund->sheba_number = $this->sheba_number;
        $refund->name = $this->name;
        $refund->quantity = $this->quantity;
        $refund->save();
        $this->emitNotify('درخواست شما با موفقیت ثبت شد');
        $this->reset(['file','sheba_number','card_number','content','order_id']);
    }

    public function render()
    {
        if (isset($this->orderBasket))
            $this->data['products'] = $this->data['orders_details'][$this->orderBasket];
        else
            $this->data['products'] = [];
        return view('livewire.site.dashboard.returns.store-return')
            ->extends('livewire.site.layouts.site.site');
    }

    public function unsetImage($key)
    {
        unset($this->file[$key]);
    }

    public function uploadFile()
    {
        // upon form submit, this function till fill your progress bar
    }

}
