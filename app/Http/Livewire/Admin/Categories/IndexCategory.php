<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Http\Livewire\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithPagination;
use App\Models\Category;

class IndexCategory extends BaseComponent
{
    use WithPagination , AuthorizesRequests;
    protected $queryString = ['status' ,'type'];
    public $status , $is_available , $type ,$placeholder = 'عنوان یا نام مستعار';
    public $pagination = 10 , $search , $data = [] ;

    public function render()
    {
        $this->authorize('show_categories');
        $categories = Category::latest('id')->when($this->status,function ($query){
            return $query->where('status',$this->status);
        })->when($this->type,function ($query){
            return $query->where('type',$this->type);
        })->search($this->search)->paginate($this->pagination);
        $this->data['status'] = Category::getStatus();
        $this->data['type'] = Category::type();
        return view('livewire.admin.categories.index-category',['categories'=>$categories])
            ->extends('livewire.admin.layouts.admin');
    }

    public function delete($id)
    {
        $this->authorize('delete_categories');
        $category = Category::findOrFail($id)->delete();
    }
}
