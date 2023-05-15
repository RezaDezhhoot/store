<?php

namespace App\Http\Livewire\FormBuilder\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static formPrice($form)
 */
class FormBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Http\Livewire\FormBuilder\FormBuilder::class;
    }
}
