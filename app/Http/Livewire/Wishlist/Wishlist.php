<?php


namespace App\Http\Livewire\Wishlist;


use Illuminate\Support\Facades\Session;

class Wishlist
{
    const WISHLIST = 'Wishlist';

    public function add($product)
    {
        $content = $this->content();
        $content->put($product->id, $product);
        session()->put(self::WISHLIST , $content);
    }

    public function get($id)
    {
        $content = $this->content();
        if (!$content->has($id))
            return (false);

        return $content->get($id);
    }


    public function delete($id)
    {
        $content = $this->content();
        if (!empty($this->get($id))) {
            $cartItem = $this->get($id);
            $content->pull($cartItem->id);
            session()->put(self::WISHLIST, $content);
        }
    }

    public function content()
    {
        return session()->has(self::WISHLIST) ? session(self::WISHLIST) : collect();
    }
}
