<?php


namespace App\Http\Livewire\Cart\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static add($product, int $quantity, $form)
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Http\Livewire\Cart\Cart::class;
    }
}
