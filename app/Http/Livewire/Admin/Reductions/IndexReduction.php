<?php

namespace App\Http\Livewire\Admin\Reductions;

use App\Http\Livewire\BaseComponent;
use App\Models\Reduction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IndexReduction extends BaseComponent
{
    public $pagination = 10 , $search , $placeholder = 'کد';
    use AuthorizesRequests;
    public function render()
    {
        $this->authorize('show_reductions');
        $reductions = Reduction::latest()
            ->search($this->search)
            ->paginate($this->pagination);
        return view('livewire.admin.reductions.index-reduction',['reductions' => $reductions])
            ->extends('livewire.admin.layouts.admin');
    }

    public function delete($id)
    {
        $this->authorize('delete_reductions');

        Reduction::findOrFail($id)->delete();

        $this->emitNotify('کد تخفیف با موفقیت حذف شد');
    }
}
