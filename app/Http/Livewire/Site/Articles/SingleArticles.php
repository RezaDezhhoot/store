<?php

namespace App\Http\Livewire\Site\Articles;

use App\Http\Livewire\BaseComponent;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Setting;
use App\Rules\ReCaptchaRule;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class SingleArticles extends BaseComponent
{
    public $article , $address , $related , $comments , $newComment , $recaptcha;
    public function mount($slug)
    {
        $this->article = Article::where([
            ['status',Article::SHARED],
            ['slug',$slug]
        ])->firstOrFail();

        SEOMeta::setTitle( $this->article->title,false);
        SEOMeta::setDescription($this->article->seo_description);
        SEOMeta::addKeyword(explode(',',$this->article->seo_keywords));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setTitle($this->article->title);
        OpenGraph::setDescription($this->article->seo_description);
        TwitterCard::setTitle($this->article->title);
        TwitterCard::setDescription($this->article->seo_description);
        JsonLd::setTitle($this->article->title);
        JsonLd::setDescription($this->article->seo_description);
        JsonLd::addImage($this->article->main_image);
        $this->address = [
            'home' => ['link' => route('home') , 'label' => 'خانه'],
            'articles' => ['link' => route('articles') , 'label' => 'مقالات'],
            'article' => ['link' => '' , 'label' => $this->article->title],
        ];
        $category = $this->article->category()->with(['childrenRecursive'])->first()->toArray();
        $ids = $this->array_value_recursive('id',$category ?? []);
        $this->related = Article::whereIn('category_id',$ids)->where([
            ['status',Article::SHARED],
            ['id','!=',$this->article->id],
        ])->take(3)->get();

        $this->comments = Comment::where([
            ['status',Comment::CONFIRMED],
            ['commentable_id',$this->article->id],
        ])->get();

    }
    public function render()
    {
        return view('livewire.site.articles.single-articles')
            ->extends('livewire.site.layouts.site.site');
    }

    public function sendComment()
    {
        $this->validate([
            'recaptcha' => ['required', new ReCaptchaRule],
            'newComment' => ['required','string','max:250']
        ], [], [
            'recaptcha' => 'تیک امنیتی',
            'newComment' => 'دیدگاه',
        ] );
        if (auth()->check()){
            Comment::create([
                'comment' => $this->newComment,
                'rating' => 2,
                'status' => Comment::NEW,
                'commentable_type' => Comment::ARTICLE,
                'commentable_id' => $this->article->id,
                'user_id' => auth()->id(),
            ]);
            $this->reset(['newComment']);
            $this->emitNotify('دیدگاه شما با موفقیت ثبت شد');
        } else{
            $this->addError('newComment','کاربر گرامی لطفا قبل از ثبت دیدگاه وارد حساب کاربری خود شوید');
        }
    }
}
