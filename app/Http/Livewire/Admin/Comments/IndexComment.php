<?php

namespace App\Http\Livewire\Admin\Comments;

use App\Http\Livewire\BaseComponent;
use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IndexComment extends BaseComponent
{
    use AuthorizesRequests;

    public $filterConfirmed = 0 , $data = [] , $search , $pagination = 10 , $status , $type , $placeholder = '';
    protected $queryString = ['status','type'];

    public function mount()
    {
        $this->data['status'] = Comment::getStatus();
        $this->data['type'] = Comment::type();
    }

    public function render()
    {
        $this->authorize('show_comments');

        $comments = Comment::latest()
            ->with('user')
            ->when($this->status, function ($query) {
                return $query->where('status', $this->status);
            })->when($this->type, function ($query) {
                return $query->where('commentable_type', $this->type);
            })
            ->paginate($this->pagination);

        return view('livewire.admin.comments.index-comment', ['comments' => $comments])
            ->extends('livewire.admin.layouts.admin');
    }

    public function delete($id)
    {
        $this->authorize('delete_comments');

        Comment::findOrFail($id)->delete();

        $this->emitNotify('نظر با موفقیت حذف شد');
    }

    public function confirm($id)
    {
        $this->authorize('edit_comments');
        Comment::where('id', $id)->update([
            'status' => Comment::CONFIRMED
        ]);

        $this->emitNotify('نظر با موفقیت تایید شد');
    }
}
