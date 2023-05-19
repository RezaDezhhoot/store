<?php

namespace App\Http\Livewire\Site\Layouts\Site;

use App\Models\Setting;
use Livewire\Component;

class Slider extends Component
{
    public $slider = [] , $title;

    public function mount()
    {
        $this->slider = Setting::getSingleRow('homeSlider');
        $this->title = Setting::getSingleRow('title');
    }
    public function render()
    {
        return view('livewire.site.layouts.site.slider');
    }
}
