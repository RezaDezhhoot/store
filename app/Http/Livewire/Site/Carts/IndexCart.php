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

    public function updated($name, $value)
    {
        $elements = explode('.', $name);

        if ($elements[0] == 'quantities'){
            $this->validate(['quantities.'.$elements[1] => ['required', 'integer', 'min:1', 'max:100']]);

            $product = Product::find($elements[1]);
            if (!is_null($product->quantity) && $product->quantity < $value) {
                return;
            }
            Cart::update($elements[1], $value);
        }
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
