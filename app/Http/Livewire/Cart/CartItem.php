<?php

namespace App\Http\Livewire\Cart;

use App\Models\Product;

class CartItem
{
    public $id;
    public $title;
    public $image;
    public $quantity;
    public $currency;
    public $price;
    public $basePrice;
    public $discount;
    public $form;
    public $delivery_time;

    public function __construct(Product $product, $quantity, $form)
    {
        $this->id = $product->id;
        $this->title = $product->title;
        $this->image = $product->image;
        $this->quantity = $quantity;
        $this->price = $product->price();
        $this->form = $form;
        $this->basePrice = $product->price;
    }

    public function price()
    {
        return ($this->basePrice + $this->formPrice()) * $this->quantity;
    }


    public function discount()
    {
        return ($this->basePrice - $this->price ) * $this->quantity;
    }

    public function total()
    {
        return $this->price() - $this->discount();
    }

    private function formPrice()
    {
        $form = collect($this->form);

        return $form->reduce(function ($total, $item) {

            $selectedValue = $item['value'] ?? '';
            $options = collect($item['options'] ?? []);
            $optionPrice = $options->reduce(function ($total, $item) use ($selectedValue) {
                $price = 0;
                if ($item['value'] == $selectedValue) {
                    $price = $total + $item['price'];
                }

                return $total + $price;
            }, 0);

            return $total + $optionPrice;
        }, 0);
    }
}
