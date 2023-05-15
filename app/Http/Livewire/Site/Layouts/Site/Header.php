<?php

namespace App\Http\Livewire\Site\Layouts\Site;

use App\Http\Livewire\BaseComponent;
use App\Models\Category;
use App\Models\Setting;

class Header extends BaseComponent
{
    public $data = [];
    public $category , $q;

    public function search()
    {
        if (!is_null($this->q) || !is_null($this->category))
            return redirect()->route('shop',['category' => $this->category ,'q' => $this->q]);
    }

    public function render()
    {
        $this->data['tel'] = Setting::getSingleRow('tel');
        $this->data['email'] = Setting::getSingleRow('email');
        $this->data['contact'] = Setting::getSingleRow('contact',[]);
        $this->data['logo'] = Setting::getSingleRow('logo');
        $this->data['categories'] = Category::with(['childrenRecursive'])->where([
            ['status',Category::AVAILABLE],
            ['type',Category::PRODUCT],
        ])->whereNull('parent_id')->get();
        return view('livewire.site.layouts.site.header');
    }
}
