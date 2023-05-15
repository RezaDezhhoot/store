<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Http\Livewire\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Setting;
class FaqSettingStore extends BaseComponent
{
    use AuthorizesRequests;
    public $question , $answer , $faq , $header , $mode;
    public function mount($action , $id = null)
    {
        $this->authorize('show_settings_fag');
        if ($action == 'edit')
        {
            $this->faq = Setting::findOrFail($id);
            $this->header = $id;
            $this->answer = $this->faq->value['answer'];
            $this->question = $this->faq->value['question'];
        } else $this->header = 'سوال جدید';
        $this->mode = $action;
    }

    public function store()
    {
        $this->authorize('edit_settings_fag');
        if ($this->mode == 'edit')
            $this->saveInDataBase($this->faq);
        elseif ($this->mode == 'create')
        {
            $this->saveInDataBase(new Setting());
            $this->reset(['question','answer']);
        }
    }

    public function saveInDataBase(Setting $setting)
    {
        $this->validate([
            'question' => ['required','string','max:80000'],
            'answer' => ['required','string','max:80000'],
        ],[],[
            'question' => 'سوال',
            'answer' => 'جواب',
        ]);
        $data = [
            'question' => $this->question,
            'answer' => $this->answer,
        ];
        $setting->value = json_encode($data);
        $setting->name = 'faq';
        $setting->save();
        $this->emitNotify('اطلاعات با موفقیت ثبت شد');
    }

    public function deleteItem()
    {
        $this->authorize('edit_settings_fag');
        $this->faq->delete();
        return redirect()->route('admin.setting.faq');
    }

    public function render()
    {
        return view('livewire.admin.settings.faq-setting-store')
            ->extends('livewire.admin.layouts.admin');
    }
}
