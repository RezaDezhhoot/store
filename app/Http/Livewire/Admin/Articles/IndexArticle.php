<?php

namespace App\Http\Livewire\Admin\Articles;

use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Livewire\BaseComponent;
use Livewire\WithPagination;
use App\Models\Article;

class IndexArticle extends BaseComponent
{
    use WithPagination , AuthorizesRequests;
    protected $queryString = ['status'];
    public $status;
    public $pagination = 10 , $search , $data = [] , $placeholder = 'عنوان یا نام مستعار';

    public function render()
    {
        $this->authorize('show_articles');
        $articles = Article::latest('id')->when($this->status,function ($query){
            return $query->where('status',$this->status);
        })->search($this->search)->paginate($this->pagination);
        $this->data['status'] = Article::getStatus();
        return view('livewire.admin.articles.index-article',['articles'=>$articles])->extends('livewire.admin.layouts.admin');
    }
    public function delete($id)
    {
        $this->authorize('delete_articles');
        Comment::where([
            ['commentable_type',Comment::ARTICLE],
            ['commentable_id',$id],
        ])->delete();
        Article::findOrFail($id)->delete();
    }
}
