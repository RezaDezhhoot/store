<?php

namespace App\Http\Livewire\Admin\Refunds;

use App\Http\Livewire\BaseComponent;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderNote;
use App\Models\Refund;
use App\Traits\Admin\TextBuilder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Sends\SendMessages;

class StoreRefund extends BaseComponent
{
    use TextBuilder , AuthorizesRequests;
    public $mode , $refund , $data = [] , $header , $content , $images , $status , $result;
    public function mount($action , $id = null)
    {
        $this->authorize('show_orders');
        if ($action == 'edit')
        {
            $this->refund = Refund::findOrFail($id);
            $this->status = $this->refund->status;
            $this->content = $this->refund->content;
            $this->result = $this->refund->result;
            $this->images = $this->refund->images;
            $this->header = 'مرجوعیت سفارش با کد پیگیری : '.$this->refund->order->tracking_code;
        } else abort(404);

        $this->mode = $action;
        $this->data['status'] = Refund::getStatus();
    }

    public function deleteItem()
    {
        $this->authorize('delete_orders');
        $texts = [];
        if ($this->refund->status == Refund::NEW)
        {
            $texts = $this->createText('order_wc_refunded_rej',$this->refund->order);
            $send = new SendMessages();
            $send->sends($texts,$this->refund->order->order->user,Notification::ORDER,$this->refund->order->id);
            $this->refund->order->status = Order::STATUS_COMPLETED;
            $this->refund->order->save();
        }
        $this->refund->delete();
        return redirect()->route('admin.refund');
    }

    public function store()
    {
        if ($this->mode == 'edit')
            $this->saveInDataBase($this->refund);
    }

    public function saveInDataBase(Refund $refund)
    {
        $this->validate([
            'content' => ['required','string','max:2000'],
            'images' => ['required','string','max:2000'],
            'status' => ['required','in:'.implode(',',array_keys(Refund::getStatus()))],
            'result' => ['nullable','string','max:36000']
        ],[],[
            'content' => 'توضیحات',
            'images' => 'تصاویر',
            'status' => 'وضعیت',
            'result' => 'نتیجه',
        ]);
        if ($refund->status != $this->status){
            $send = new SendMessages();
            $texts = [];
            switch ($this->status){
                case Refund::REJECT:{
                    $refund->order->status = Order::STATUS_COMPLETED;
                    $texts = $this->createText('order_wc_refunded_rej',$refund->order);break;
                }
                case Refund::ACCEPTED:{
                    $refund->order->status = Order::STATUS_REFUNDED;
                    $texts = $this->createText('order_wc_refunded',$refund->order);
                    break;
                }
            }
            $refund->order->save();
            $send->sends($texts,$refund->order->order->user, Notification::ORDER,$refund->order->id);
            if (sizeof($texts)>0){
                $text = array_values(array_values($texts)[0])[0];
                OrderNote::create([
                    'note' => $text,
                    'is_user_note' => true,
                    'is_read' => false,
                    'order_id' => $refund->order->id,
                    'user_id' => null,
                ]);
            }
        }

        $refund->content = $this->content;
        $refund->images = $this->images;
        $refund->status = $this->status;
        $refund->result = $this->result;
        $refund->save();
        $this->emitNotify('اطلاعات با موفقیت ثبت شد');
    }

    public function render()
    {
        return view('livewire.admin.refunds.store-refund')
            ->extends('livewire.admin.layouts.admin');
    }
}
