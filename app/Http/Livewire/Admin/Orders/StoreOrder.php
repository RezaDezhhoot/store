<?php

namespace App\Http\Livewire\Admin\Orders;

use App\Http\Livewire\BaseComponent;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderNote;
use App\Traits\Admin\TextBuilder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Sends\SendMessages;

class StoreOrder extends BaseComponent
{
    use AuthorizesRequests , TextBuilder;
    public $mode , $order , $data = [] , $statuses , $details;

    public function mount($action , $id = null)
    {
        $this->authorize('show_orders');
        if ($action == 'edit'){
            $this->order = Order::findOrFail($id);
            $this->statuses = $this->order->details()->pluck('status','id');
            $this->details = $this->order->details;
        } else abort(404);

        $this->data['status'] = Order::getStatus();
    }

    public function store()
    {
        $this->authorize('edit_orders');
        $this->validate([
            'statuses.*' => ['required','in:'.implode(',',array_keys(Order::getStatus()))]
        ]);
        $send = new SendMessages();
        foreach ($this->statuses as $key => $status)
        {
            $detail = null;
            $detail = OrderDetail::findOrFail($key);
            if ($status != $detail->status)
            {
                $detail->status = $status;
                $detail->save();
                $texts = [];
                switch ($status){
                    case Order::STATUS_HOLD:$texts = $this->createText('order_on_hold',$detail);break;
                    case Order::STATUS_PROCESSING:$texts = $this->createText('order_wc_processing',$detail);break;
                    case Order::STATUS_STORE:$texts = $this->createText('order_wc_custom_status',$detail);break;
                    case Order::STATUS_POST:$texts = $this->createText('order_wc_post',$detail);break;
                    case Order::STATUS_CANCELLED:$texts = $this->createText('order_wc_cancelled',$detail);break;
                    case Order::STATUS_REFUNDED:$texts = $this->createText('order_wc_refunded',$detail);break;
                    case Order::STATUS_COMPLETED:$texts = $this->createText('order_wc_completed',$detail);break;
                }
                $send->sends($texts,$this->order->user,Notification::ORDER,$this->order->id);
                if (sizeof($texts)>0){
                    $text = array_values(array_values($texts)[0])[0];
                    $note = OrderNote::create([
                        'note' => $text,
                        'is_user_note' => true,
                        'is_read' => false,
                        'order_id' => $detail->id,
                        'user_id' => null,
                    ]);
                    foreach ($this->details as $key2 => $item)
                        if ($item->id == $detail->id)
                            $item->note->push($note);
                }
            }
        }
        $this->emitNotify('اطلاعات با موفقیت ثبت شد');
    }

    public function deleteDetail($key)
    {
        $this->authorize('delete_orders');
        $id = $this->order->details[$key]->id;

        OrderDetail::findOrFail($id)->delete();
        unset($this->order->details[$key]);
    }

    public function deleteItem()
    {
        $this->authorize('delete_orders');
        Order::findOrFail($this->order->id)->delete();
        return redirect()->route('admin.order');
    }

    public function render()
    {
        return view('livewire.admin.orders.store-order')
            ->extends('livewire.admin.layouts.admin');
    }
}
