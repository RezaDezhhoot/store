<?php

namespace App\Http\Livewire\Admin\Comments;

use App\Http\Livewire\BaseComponent;
use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class StoreComment extends BaseComponent
{
    use AuthorizesRequests;

    public $comment, $answer, $rating, $status , $mode , $text , $data = [] , $commentable , $target;

    public function mount($action, $id = null)
    {
        $this->authorize('show_comments');
        if ($action == 'create') {
            abort(404);
        } elseif ($action == 'edit') {
            $this->mode = 'edit';
            $this->comment = Comment::findOrFail($id);
            $this->answer = $this->comment->answer;
            $this->rating = $this->comment->rating;
            $this->text = $this->comment->comment;
            $this->status = $this->comment->status;
            $this->commentable = $this->comment->commentableTypeLabel;
            $this->target = $this->comment->commentable->title;

        } else {
            abort(404);
        }
        $this->data['status'] = Comment::getStatus();
        $this->data['type'] = Comment::type();
        $this->mode = $action;
    }

    public function store()
    {
        $this->authorize('edit_comments');
        $this->saveInDatabase($this->comment);
    }

    public function saveInDatabase(Comment $comment)
    {
        $this->validate(
            [
                'text' => ['required', 'string', 'max:250'],
                'answer' => ['nullable', 'string', 'max:250'],
                'rating' => ['required', 'integer', 'between:0,5'],
                'status' => ['required', 'in:'.implode(',',array_keys(Comment::getStatus()))],
            ],
            [],
            [
                'text' => 'نظر',
                'answer' => 'پاسخ',
                'rating' => 'امتیاز',
                'status' => 'وضعیت',
            ]
        );


        $comment->comment = $this->text;
        $comment->answer = $this->answer;
        $comment->rating = $this->rating;
        $comment->status = $this->status;
        $comment->save();
        $this->emitNotify('نظر با موفقیت ویرایش شد');
    }

    public function delete($id)
    {
        $this->authorize('delete_comments');

        Comment::findOrFail($id)->delete();

        $this->emitNotify('نظر با موفقیت حذف شد');
    }

    public function render()
    {
        return view('livewire.admin.comments.store-comment')
            ->extends('livewire.admin.layouts.admin');
    }
}
