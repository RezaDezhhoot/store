<?php

namespace App\Http\Livewire\Site\Articles;

use App\Http\Livewire\BaseComponent;
use App\Models\Article;
use App\Models\Category;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Livewire\WithPagination;

class IndexArticles extends BaseComponent
{
    use WithPagination;
    public $data = [] , $address , $paginate = 2 , $category , $q , $lastPosts , $categories;
    protected $queryString = ['q','category'];
    public function mount()
    {
        SEOMeta::setTitle('مقالات',false);
        SEOMeta::setDescription(Setting::getSingleRow('seoDescription'));
        SEOMeta::addKeyword(explode(',',Setting::getSingleRow('seoKeyword')));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle('مقالات');
        OpenGraph::setDescription(Setting::getSingleRow('seoDescription'));
        TwitterCard::setTitle('مقالات');
        TwitterCard::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::setTitle('مقالات');
        JsonLd::setDescription(Setting::getSingleRow('seoDescription'));
        JsonLd::addImage(Setting::getSingleRow('logo'));
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'articles' => ['link' => '' , 'label' => 'مقالات']
        ];
        $this->lastPosts = Article::where('status',Article::SHARED)->orderBy('id','desc')->take(5)->get();
        $this->categories = Category::where([
            ['type',Category::ARTICLE],
            ['status',Category::AVAILABLE],
        ])->whereNull('parent_id')->get();
    }

    public function render()
    {
        $this->data['articles'] = Article::where('status',Article::SHARED)->when($this->category,function ($query){
            $category = Category::with(['childrenRecursive'])->where([
                ['type',Category::ARTICLE],
                ['status',Category::AVAILABLE],
                ['slug',$this->category],
            ])->first()->toArray();
            $ids = $this->array_value_recursive('id',$category);
            return $query->whereIn('category_id',$ids);
        })->search($this->q)->paginate($this->paginate);
        return view('livewire.site.articles.index-articles')
            ->extends('livewire.site.layouts.site.site');
    }



    public function updateQ()
    {
    }
}
