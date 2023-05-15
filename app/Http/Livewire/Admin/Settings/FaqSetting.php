<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Http\Livewire\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\Setting;
use Livewire\WithPagination;

class FaqSetting extends BaseComponent
{
    use AuthorizesRequests , WithPagination;

    public $pagination = 10 , $search , $placeholder = 'عنوان';

    public function render()
    {
        $this->authorize('show_settings_fag');
        $faq = Setting::where('name','faq')->paginate($this->pagination);
        return view('livewire.admin.settings.faq-setting',['faq'=> $faq])
            ->extends('livewire.admin.layouts.admin');
    }

    public function delete($id)
    {
        $this->authorize('edit_settings_fag');
        Setting::findOrFail($id)->delete();
    }
}
