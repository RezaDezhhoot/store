<?php

namespace App\Http\Livewire\Admin\Articles;

use App\Http\Livewire\BaseComponent;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use Illuminate\Validation\Rule;

class StoreArticle extends BaseComponent
{
    use AuthorizesRequests;
    public $article , $mode , $header , $data = [] , $category;
    public $slug ,$title,$main_image,$content,$seo_keywords,$seo_description,$status , $sub_title;

    public $type;

    public function mount($action , $id = null)
    {
        $this->authorize('show_articles');
        if ($action == 'edit')
        {
            $this->article = Article::findOrFail($id);
            $this->header = $this->article->title;
            $this->slug = $this->article->slug;
            $this->title = $this->article->title;
            $this->main_image = $this->article->main_image;
            $this->content = $this->article->content;
            $this->seo_keywords = $this->article->seo_keywords;
            $this->seo_description = $this->article->seo_description;
            $this->status = $this->article->status;
            $this->category = $this->article->category_id;
            $this->sub_title = $this->article->sub_title;
            $this->type = $this->article->type;
        } elseif($action == 'create') $this->header = 'مقاله جدید';
        else abort(404);

        $this->mode = $action;
        $this->data['category'] = Category::where([
            ['status',Category::AVAILABLE],
            ['type',Category::ARTICLE]
        ])->pluck('title','id');
        $this->data['status'] = Article::getStatus();
        $this->data['type'] = Article::getType();
    }

    public function deleteItem()
    {
        $this->authorize('delete_articles');
        Comment::where([
            ['commentable_type',Comment::ARTICLE],
            ['commentable_id',$this->article->id],
        ])->delete();
        $this->article->delete();
        return redirect()->route('admin.article');
    }

    public function store()
    {
        $this->authorize('edit_articles');
        if ($this->mode == 'edit')
            $this->saveInDateBase($this->article);
        else{
            $this->saveInDateBase(new Article());
            $this->reset(['slug','title','main_image','content','seo_keywords','seo_description','status','category','sub_title','type']);
        }
    }

    public function saveInDateBase(Article $model)
    {
        $fields = [
            'slug' => ['required','string','unique:articles,slug,'.($this->article->id ?? 0)],
            'title' => ['required','string','max:100'],
            'main_image' => ['nullable','string','max:250'],
            'content' => ['required','string'],
            'sub_title' => ['nullable','string','max:255'],
            'seo_keywords' => ['required','string','max:250'],
            'seo_description' => ['required','string','max:250'],
            'status' => ['required','in:'.Article::SHARED.','.Article::DEMO],
            'category' => ['nullable','exists:categories,id'],
            'type' => ['required','string',Rule::in(array_keys(Article::getType()))]
        ];
        $messages = [
            'slug' => 'نام مستعار',
            'title' => 'عنوان',
            'main_image' => 'تصویر',
            'content' => 'محتوا',
            'seo_keywords' => 'کلمات کلیدی',
            'seo_description' => 'توضیحات سئو',
            'status' => 'وضعیت',
            'category' => 'دسته',
            'sub_title' => 'زیر عنوان',
            'type' => 'نوع نوشته'
        ];
        $this->validate($fields,[],$messages);

        $model->slug = $this->slug;
        $model->title = $this->title;
        $model->main_image = $this->main_image ?? '';
        $model->content = $this->content;
        $model->seo_keywords = $this->seo_keywords;
        $model->seo_description = $this->seo_description;
        $model->status = $this->status;
        $model->category_id = $this->category;
        $model->sub_title = $this->sub_title;
        $model->type = $this->type;
        $model->user_id = Auth::id();
        $model->save();


        $this->emitNotify('اطلاعات با موفقیت ثبت شد');

    }

    public function render()
    {
        return view('livewire.admin.articles.store-article')->extends('livewire.admin.layouts.admin');
    }
}
