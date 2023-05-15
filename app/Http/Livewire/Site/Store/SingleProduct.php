<?php

namespace App\Http\Livewire\Site\Store;

use App\Http\Livewire\BaseComponent;
use App\Models\Comment;
use App\Models\Product;
use App\Http\Livewire\Cart\Facades\Cart;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use App\Http\Livewire\FormBuilder\Facades\FormBuilder;

class SingleProduct extends BaseComponent
{
    public $readyToLoad = false , $priceWithDiscount;
    public $isLoaded = false;
    public $form, $price;
    public $product , $address , $quantity  = 1 , $comments , $related = [];

    public function mount($slug)
    {
        $this->product = Product::where([
            ['slug',$slug],
            ['status',Product::STATUS_AVAILABLE],
        ])->firstOrFail();
        SEOMeta::setTitle($this->product->title,false);
        OpenGraph::setTitle($this->product->title);
        TwitterCard::setTitle($this->product->title);
        JsonLd::setTitle($this->product->title);
        SEOMeta::setDescription($this->product->seo_description);
        SEOMeta::addKeyword(explode(',',$this->product->seo_keyword));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setDescription($this->product->seo_description);
        TwitterCard::setDescription($this->product->seo_description);
        JsonLd::setDescription($this->product->seo_description);
        JsonLd::addImage($this->product->seo_description);
        if (!is_null($this->product->category) && !empty($this->product->category)){
            $this->address = [
                'home' => ['link' => route('home'),'label' => 'خانه'],
                'store' => ['link' => route('shop') ,'label' => 'فورشکاه'],
                'category' => ['link' => route('shop',$this->product->category->slug),'label'=>$this->product->category->title],
                'product' => ['link' => '' , 'label' => $this->product->title]
            ];
            $category = $this->product->category()->with(['childrenRecursive'])->first()->toArray();
            $ids = $this->array_value_recursive('id',$category ?? []);
            $this->related = Product::whereIn('category_id',$ids)->where([
                ['status',Product::STATUS_AVAILABLE],
                ['id','!=',$this->product->id],
            ])->get();
        } else {
            $this->address = [
                'home' => ['link' => route('home'),'label' => 'خانه'],
                'store' => ['link' => route('shop') ,'label' => 'فورشکاه'],
                'product' => ['link' => '' , 'label' => $this->product->title]
            ];
        }

        $this->comments = Comment::latest('id')->where([
            ['commentable_type',Comment::PRODUCT],
            ['status',Comment::CONFIRMED],
            ['commentable_id',$this->product->id]
        ])->get();


        $form = array_reverse($this->product->form);
        $this->form = $form;
        $this->price = $this->product->price();
        $this->priceWithDiscount = $this->product->price;
    }

    public function updatedQuantity()
    {
        $this->validate(['quantity' => ['required', 'integer', 'min:1', 'max:100']]);
        $this->calculatePrice();
    }

    public function updatedForm()
    {
        $this->validate(['quantity' => ['required', 'integer', 'min:1', 'max:100']]);
        $this->calculatePrice();
    }

    public function calculatePrice()
    {
        foreach ($this->form as $key => $item) {
            foreach ($item['options'] as $optionKey => $option) {
                if ($option['value'] == $item['value'] && isset($option['license']) && $option['license'] != '') {
                    $product = Product::where('slug', $option['license'])->first();
                    $this->form[$key]['options'][$optionKey]['price'] = $product->price - $product->discount_amount;
                }
            }
        }
        $form = collect($this->form);
        $formPrice = $form->reduce(function ($total, $item) {

            $formItem = $item;
            $selectedValue = $item['value'];
            $options = collect($item['options'] ?? []);
            $optionPrice = $options->reduce(function ($total, $item) use ($selectedValue, $formItem) {
                $price = 0;
                if (FormBuilder::isVisible($this->form, $formItem) && $item['value'] == $selectedValue) {
                    @$price = $total + $item['price'] * ($this->product->currency->amount ?? 1);

                    if (isset($option['license']) && $option['license'] != '') {
                        $product = Product::where('slug', $option['license'])->first();
                        $price = $product->price - $product->discount_amount;
                    }
                }
                return $total + $price;
            }, 0);

            return $total + $optionPrice;
        }, 0);

        $this->price = round(($this->product->price() + $formPrice) * $this->quantity);
        $this->priceWithDiscount = round(($this->product->price + $formPrice) * $this->quantity);
    }

    public function render()
    {
        if ($this->readyToLoad && !$this->isLoaded) {
            $this->isLoaded = true;
        }
        return view('livewire.site.store.single-product')
            ->extends('livewire.site.layouts.site.site');
    }

    public function addToCart()
    {
        $this->validate(['quantity' => ['required', 'integer', 'min:1', 'max:100']]);

        //check if available
        if ($this->product->status != Product::STATUS_AVAILABLE) {
            return;
        }

        //check quantity
        if (!is_null($this->product->quantity) && $this->product->quantity < $this->quantity) {
            $this->addError('error', 'موجودی محصول به اتمام رسیده');
            return;
        }

        //validate form
        $this->resetErrorBag();
        foreach ($this->form as $key => $item) {
            if (FormBuilder::isVisible($this->form, $item) && $item['required'] && strlen($item['value']) == 0) {
                $this->addError('form.' . $key . '.error', __('validation.required', ['attribute' => '']));
            }
        }

        if (sizeof($this->getErrorBag()) > 0) {

            $this->addError('error', 'موارد خواسته شده را تکمیل کنید');
            return;
        }

        Cart::add($this->product, $this->quantity, $this->form);
        redirect()->route('cart');
    }
}
