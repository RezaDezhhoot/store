<?php

namespace App\Http\Livewire\Admin\Sends;

use App\Http\Livewire\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Send;

class StoreSend extends BaseComponent
{
    use AuthorizesRequests;
    public $transfer , $mode , $header , $data = [];
    public $slug , $logo , $price  , $note  ;

    public function mount($action  ,$id = null)
    {
        $this->authorize('show_sends');
        if ($action == 'edit')
        {
            $this->transfer = Send::findOrFail($id);
            $this->header = $this->transfer->slug;
            $this->slug = $this->transfer->slug;
            $this->logo = $this->transfer->logo;
            $this->price = $this->transfer->price;
            $this->note = $this->transfer->note;
        } elseif($action == 'create') $this->header = 'روش ارسال جدید';
        else abort(404);

        $this->mode = $action;
    }

    public function store()
    {
        $this->authorize('edit_sends');
        if ($this->mode == 'edit')
            $this->saveInDataBase($this->transfer);
        else{
            $this->saveInDataBase(new Send());
            $this->reset(['slug','logo','price','note']);
        }
    }

    public function saveInDataBase(Send $model)
    {
        $fields = [
            'slug' => ['required','max:150','string','unique:sends,slug,'.($this->transfer->id ?? 0)],
            'logo' => ['required','string','max:150'],
            'price' => ['required','numeric','between:0,999999999.99999'],
            'note' => ['nullable','string','max:255'],
        ];
        $messages = [
            'slug' => 'نام مستعار',
            'logo' => 'ایکون',
            'price' => 'هزینه ارسال',
            'note' => 'توضیحات',
        ];
        $this->validate($fields,[],$messages);

        $model->slug = $this->slug;
        $model->logo = $this->logo;
        $model->price = $this->price;
        $model->note = $this->note;
        $model->save();
        $this->emitNotify('اطلاعات با موفقیت ثبت شد');

    }

    public function deleteItem()
    {
        $this->authorize('delete_sends');
        $this->transfer->delete();
        return redirect()->route('admin.transfer');
    }

    public function render()
    {
        return view('livewire.admin.sends.store-send')->extends('livewire.admin.layouts.admin');
    }
}
