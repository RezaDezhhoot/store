<?php

namespace App\Http\Livewire\Admin\Orders;

use App\Http\Livewire\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Order;
use Livewire\WithPagination;

class IndexOrder extends BaseComponent
{
    use AuthorizesRequests , WithPagination;
    protected $queryString = ['status'];
    public $mode , $data = [] , $status , $pagination , $search , $placeholder = 'کد پیگیری سبد یا خوده سفارش یا شماره همراه';

    public function render()
    {
        $this->authorize('show_orders');
        $orders = Order::with(['details'])->latest('id')->when($this->status,function ($query){
            $query->whereHas('details',function ($query){
               return $query->where('status',$this->status);
            });
        })->when($this->search,function ($query){
            $query->whereHas('user',function ($query){
                return $query->where('phone',$this->search);
            })->orWhereHas('details',function ($query){
                return $query->where('id',(int)$this->search - Order::CHANGE_ID);
            })->orWhere('id',(int)$this->search-Order::CHANGE_ID);
        })->paginate($this->pagination);
        $this->data['status'] = Order::getStatus();
        return view('livewire.admin.orders.index-order',['orders' => $orders])
            ->extends('livewire.admin.layouts.admin');
    }

    public function delete($id)
    {
        $this->authorize('delete_orders');
        Order::findOrFail($id)->delete();
    }

}
