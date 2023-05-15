<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Http\Livewire\BaseComponent;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\User , App\Models\Order;
use App\Models\Payment;
use App\Models\Category ;
use App\Models\Ticket , App\Models\Comment;
class IndexDashboard extends BaseComponent
{
    public $from_date , $to_date , $now , $box;

    public function mount()
    {
        $this->now = Carbon::now()->format('Y-m-d');
        $this->to_date = Carbon::now()->format('Y-m-d');
        $this->from_date = Carbon::now()->subDays(5)->format('Y-m-d');
        $this->getData();
    }

    public function emitEvent()
    {
        $this->emit('runChart',$this->getChartData());
    }

    public function confirmFilter()
    {
        $this->getData();
        $this->emit('runChart',$this->getChartData());
    }


    public function getData()
    {
        $this->box = [
            'orders'=> OrderDetail::whereBetween('created_at', [$this->from_date." 00:00:00", $this->to_date." 23:59:59"])->count(),
            'users'=> User::whereBetween('created_at', [$this->from_date." 00:00:00", $this->to_date." 23:59:59"])->count(),
            'payments'=> Payment::whereBetween('created_at', [$this->from_date." 00:00:00", $this->to_date." 23:59:59"])->sum('amount'),
        ];
    }

    public function getChartData()
    {
        $chart = [];
        $dates = $this->getDates();
        $chartModels = [
            'payments' => ['model' => new Payment(),
                'where' => ['payment_ref' , '!=' , null] , 'sum' => 'amount'],
        ];
        foreach ($chartModels as $key => $chartModel) {
            $chart[$key] = [];
            $chart['label'] = [];
            for ($i = 0 ; $i< count($dates); $i++) {
                $chart[$key][] = (float)$chartModel['model']->where([$chartModel['where']])
                    ->whereBetween('created_at', [$dates[$i]->format('Y-m-d') . " 00:00:00", $dates[$i]->format('Y-m-d') . " 23:59:59"])
                    ->sum($chartModel['sum']);
                $chart['label'][] = (string)$dates[$i]->format('Y-m-d');

            }
        }
        return $chart;
    }
    public function getDates()
    {
        $period = CarbonPeriod::create($this->from_date, $this->to_date);
        foreach ($period as $date) {
            $date->format('Y-m-d');
        }
        return $period->toArray();
    }

    public function render()
    {
        $list = [
            'comments' => Comment::latest('id')->take(30)->get(),
            'tickets' => Ticket::latest('id')->where([
                ['sender_type',Ticket::USER],
            ])->take(30)->get(),
            'products' => Product::withCount('orders')->orderBy('id')->take(20)->get(),
        ];
        return view('livewire.admin.dashboard.index-dashboard',['list'=>$list])
            ->extends('livewire.admin.layouts.admin');
    }
}
