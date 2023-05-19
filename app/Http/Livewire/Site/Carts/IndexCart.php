<?php

namespace App\Http\Livewire\Site\Carts;

use App\Http\Livewire\BaseComponent;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Http\Livewire\Cart\Facades\Cart;
use App\Models\Product;
use Livewire\WithPagination;

class IndexCart extends BaseComponent
{
    use WithPagination;
    public $data = [] , $address , $cart , $cartContent;
    public $quantities;
    public function mount()
    {
        SEOMeta::setTitle('سبد خرید',false);
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('سبد خرید');
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'cart' => ['link' => '' , 'label' => 'سبد خرید']
        ];

        foreach (Cart::content() as $item){
            $this->quantities[$item->id] = $item->quantity;
        }
    }

    public function updatedQuantities($value, $key)
    {
            $product = Product::find($key);
            if (!is_null($product->quantity) && $product->quantity < $value) {
                return;
            }
            Cart::update($key, $value);
    }


    public function render()
    {
        $this->cartContent = Cart::content();
        $this->emit('updateBasketCount');
        return view('livewire.site.carts.index-cart')
            ->extends('livewire.site.layouts.site.site');
    }

    public function delete($key)
    {
        try {
            Cart::delete($key);
        } catch (\Exception $exception){
            //
        }
    }
}
