<?php

namespace App\Http\Livewire\Site\Store;

use App\Http\Livewire\BaseComponent;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Livewire\WithPagination;

class IndexStore extends BaseComponent
{
    use WithPagination;
    public $data = [] , $address , $single_category , $maxPrice , $minPrice , $q;
    public $groups ,$sub_category, $sub_categories = [] , $priceRange = 100  , $ids;
    public $most_amount = 'desc', $filters = [] , $filter = [] , $categories;

    protected $queryString = ['q'];
    public function mount($category = null)
    {
        if (empty($category))
        {
            SEOMeta::setTitle('فروشگاه',false);
            OpenGraph::setTitle('فروشگاه');
            TwitterCard::setTitle('فروشگاه');
            JsonLd::setTitle('فروشگاه');
            $this->categories = Category::whereNull('parent_id')->where([
                ['type',Category::PRODUCT],
                ['status',Category::AVAILABLE]
            ])->get();
        } else {
            $this->single_category = Category::with(['childrenRecursive'])->where([
                ['slug',$category],
                ['type',Category::PRODUCT],
                ['status',Category::AVAILABLE]
            ])->firstOrFail();
            SEOMeta::setTitle(' محصولات '.$this->single_category->title,false);
            OpenGraph::setTitle(' محصولات '.$this->single_category->title);
            TwitterCard::setTitle(' محصولات '.$this->single_category->title);
            JsonLd::setTitle(' محصولات '.$this->single_category->title);
            $this->ids = $this->array_value_recursive('id',$this->single_category->toArray());
            if(is_null($this->single_category->parent_id))
                $this->sub_categories = $this->single_category->toArray()['children_recursive'];

            $this->groups = $this->single_category->groups()->with('filters')->get()->toArray();
        }
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'shop' => ['link' => '' , 'label' => 'فروشگاه']
        ];

    }
    public function render()
    {
        if(!empty($this->sub_category))
            $max = Product::with(['category'])->where('category_id', $this->sub_category)->max('price');
        elseif(!empty($this->ids))
            $max = Product::with(['category'])->whereIn('category_id', $this->ids)->max('price');
        else
            $max = Product::with(['category'])->where('status',Product::STATUS_AVAILABLE)->max('price');

        $range = ($this->priceRange/100)*($max);
        if (!empty($this->single_category)){
            $filter = [];
            foreach($this->filter as $key => $value)
                if ($value == true)
                    $filter[] = $key;

            if(empty($filter))
                $this->reset(['filter']);

            if(empty($this->sub_category))
                $this->reset(['sub_category']);

            $products = Product::with(['category'])->whereIn('category_id', $this->ids)->when($this->filter,function($query) use ($filter){
                return $query->whereHas('filters',function($query) use ($filter){
                    return $query->whereIn('filter_id',$filter);
                });
            })->when($this->sub_category,function($query){
                return $query->where('category_id',$this->sub_category);
            })->when($this->most_amount,function($query){
                return $query->orderBy('price',$this->most_amount);
            })->where([
                ['status',Product::STATUS_AVAILABLE],
                ['price','>=', 0],
                ['price','<=', $range]])->search($this->q)->paginate(10);
            $link = $products->links('livewire.site.layouts.site.paginate');
            return view('livewire.site.store.index-store',['range' => $range , 'max' => $max,'products' => $products,'link' => $link])
                ->extends('livewire.site.layouts.site.site');
        } else {
            $products = Product::where([
                ['status',Product::STATUS_AVAILABLE],
                ['price','>=', 0],
                ['price','<=', $range]])->when($this->most_amount,function($query){
                return $query->orderBy('price',$this->most_amount);
            })->search($this->q)->paginate(10);
            $link = $products->links('livewire.site.layouts.site.paginate');
            return view('livewire.site.store.index-store',['range' => $range , 'max' => $max,'products' => $products,'link' => $link])
                ->extends('livewire.site.layouts.site.site');
        }
    }
}
