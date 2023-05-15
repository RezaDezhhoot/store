<?php

namespace App\Http\Livewire\Admin\Refunds;

use App\Http\Livewire\BaseComponent;
use App\Models\Notification;
use App\Models\Order;
use App\Sends\SendMessages;
use App\Traits\Admin\TextBuilder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Refund;
use Livewire\WithPagination;

class IndexRefund extends BaseComponent
{
    use AuthorizesRequests ,WithPagination , TextBuilder;

    protected $queryString = ['status'];
    public $mode , $data = [] , $status , $pagination , $search , $placeholder = 'کد پیگیری';

    public function render()
    {
        $this->authorize('show_orders');
        $refunds = Refund::with(['order'])->latest('id')->when($this->status,function ($query){
            return $query->where('status',$this->status);
        })->when($this->search,function ($query){
            return $query->whereHas('order',function ($query){
                return $query->where('id',$this->search - Order::CHANGE_ID);
            });
        })->paginate($this->pagination);

        $this->data['status'] = Refund::getStatus();

        return view('livewire.admin.refunds.index-refund',['refunds' => $refunds])
            ->extends('livewire.admin.layouts.admin');
    }

    public function delete($id)
    {
        $this->authorize('delete_orders');
        $texts = [];
        $refund = Refund::findOrFail($id);
        if ($refund->status == Refund::NEW)
        {
            $texts = $this->createText('order_wc_refunded_rej',$refund->order);
            $send = new SendMessages();
            $send->sends($texts,$refund->order->order->user,Notification::ORDER,$refund->order->id);
            $refund->order->status = Order::STATUS_COMPLETED;
            $refund->order->save();
        }
        $refund->delete();
    }
}
