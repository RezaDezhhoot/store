<?php

namespace App\Http\Livewire\Admin\Sends;

use App\Http\Livewire\BaseComponent;
use App\Models\Send;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithPagination;

class IndexSend extends BaseComponent
{
    use WithPagination , AuthorizesRequests;

    protected $queryString = ['status'];
    public $status;
    public $pagination = 10 , $search , $data = [],$placeholder = ' نام مستعار';

    public function render()
    {
        $this->authorize('show_sends');
        $sends = Send::latest('id')->search($this->search)->paginate($this->pagination);
        return view('livewire.admin.sends.index-send',['sends'=>$sends])->extends('livewire.admin.layouts.admin');
    }

    public function delete($id)
    {
        $this->authorize('delete_sends');
        Send::findOrFail($id)->delete();
    }
}
