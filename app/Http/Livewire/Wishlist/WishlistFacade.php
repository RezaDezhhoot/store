<?php


namespace App\Http\Livewire\Wishlist;

use Illuminate\Support\Facades\Facade;

class WishlistFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Wishlist::class;
    }
}
