<?php

namespace App\Http\Livewire\Admin\Products;

use App\Http\Livewire\BaseComponent;
use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Product;
use App\Traits\Admin\FormBuilder;

class IndexProduct extends BaseComponent
{
    use AuthorizesRequests;
    use FormBuilder;

    use WithPagination ;
    protected $queryString = ['status','category'];
    public $pagination = 10 ,$status,  $search , $category , $data = [] , $placeholder = 'عنوان';


    public function mount()
    {
        $this->authorize('show_products');
        $this->data['category'] = Category::with('childrenRecursive')->whereNull('parent_id')->get();
    }

    public function render()
    {
        $products = Product::latest('id')
            ->when($this->category, function ($query){
                $categoriesId = Category::where('parent_id', $this->category)->get()->pluck('id')->toArray();
                return $query->whereIn('category_id', array_merge($categoriesId, [$this->category]));
            })
            ->search($this->search)
            ->paginate($this->pagination);

        return view('livewire.admin.products.index-product',['products' => $products])
            ->extends('livewire.admin.layouts.admin');
    }


    public function delete($id)
    {
        $this->authorize('delete_products');
        $product = Product::findOrFail($id);
        Comment::where([
            ['commentable_type',Comment::PRODUCT],
            ['commentable_id',$id],
        ])->delete();
        $product->delete();
        $this->emitNotify('محصول با موفقیت حذف شد');
    }
}
