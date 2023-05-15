<?php


namespace App\Http\Livewire\Cart;


use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Cart
{
    const CART_NAME = 'cart';

    public function add($product, $quantity, $form)
    {
        $content = $this->content();


        foreach ($form as $key => $item) {

            $form[$key]['price'] = 0;
            foreach ($item['options'] as $option) {

                if (($option['value'] ?? '')  == $item['value']) {
                    $form[$key]['price'] = $option['price'];
                }

                if (($option['value'] ?? '') == $item['value'] && isset($option['license']) && $option['license'] != '') {
                    $product = Product::where('slug', $option['license'])->first();
                    $form = [];
                }
            }
        }

        $cartItem = new CartItem($product, $quantity, $form);
        $content->put($product->id, $cartItem);

        session()->put(self::CART_NAME, $content);
    }

    public function get($id)
    {
        $content = $this->content();

        if (!$content->has($id))
            throw new \Exception("The cart does not contain rowId {$id}.");

        return $content->get($id);
    }

    public function update($id, $quantity)
    {
        $content = $this->content();

        $cartItem = $this->get($id);
        $cartItem->quantity = $quantity;
        $content->put($cartItem->id, $cartItem);

        session()->put(self::CART_NAME, $content);
    }

    public function delete($id)
    {
        $content = $this->content();

        $cartItem = $this->get($id);
        $content->pull($cartItem->id);

        session()->put(self::CART_NAME, $content);
    }

    public function content()
    {
        return session()->has(self::CART_NAME) ? session(self::CART_NAME) : collect();
    }

    public function isEmpty()
    {
        return sizeof($this->content()) == 0;
    }

    public function count()
    {
        $content = $this->content();

        return $content->sum('quantity');
    }

    public function price()
    {
        $content = $this->content();

        return $content->reduce(function ($total, CartItem $cartItem) {
            return $total + $cartItem->price();
        }, 0);
    }

    public function discount()
    {
        $content = $this->content();

        return $content->reduce(function ($total, CartItem $cartItem) {
            return $total + $cartItem->discount();
        }, 0);
    }

    public function total($walletAmount = 0, $voucherAmount = 0 , $sendAmount = 0)
    {
        $content = $this->content();

        return (int)$content->reduce(function ($total, CartItem $cartItem) {
                return $total + $cartItem->total();
            }, 0) - $walletAmount - $voucherAmount + $sendAmount;
    }

    public function destroy()
    {
        session()->forget(self::CART_NAME);
    }
}
