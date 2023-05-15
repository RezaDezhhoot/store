<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Http\Livewire\BaseComponent;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\FilterGroup;
use App\Models\Filter;

class StoreCategory extends BaseComponent
{
    use AuthorizesRequests;
    public $category;
    public $mode;
    public $slug , $title  , $logo  , $description , $type , $parent , $header , $slider , $seo_keywords , $seo_description;
    public $data = [] , $status;

    public $group_title , $modal_title , $modes , $filters = [] , $i;


    public $groupList = [];

    public function addGroup($title)
    {
        if ($title == 'new')
            $this->modal_title = 'گروه جدید';
        else {
            $group = $this->groupList[$title];
            $this->modal_title = $group['title'].'ویرایش گروه ';
            $this->group_title = $group['title'];
            $this->filters = $group['filters'];
        }
        $this->modes = $title;
        $this->emitShowModal('newGroup');
    }

    public function array_value_recursive($key, array $arr){
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }

    public function storeGroup()
    {
        $filter = [];
        $this->validate(
            [
                'group_title' => ['required', 'string','max:255'],
            ] , [] , [
                'group_title' => 'عنوان',
            ]
        );
        foreach ($this->filters as $key => $item)
        {
            if(empty($item['title']))
                return $this->addError('error','عنوان فیلتر الزامی می باشد');
            $filter[] = [
                'id' => $item['id'] ?? 0,
                'group_id' => $this->modes <> 'new' ? $this->groupList[$this->modes]['id'] : 0,
                'title' => $item['title'],
                'created_at' => $item['created_at'] ?? '',
                'updated_at'=> $item['updated_at'] ?? ''
            ];
        }
        $group = [
            'id' => 0,
            'title' => $this->group_title,
            'filters' => $filter
        ];
        if ($this->modes === 'new')
            array_push($this->groupList,$group);
        else {
            $group['id'] = $this->groupList[$this->modes]['id'];
            $group['category_id'] = $this->model->id ?? 0;
            $group['created_at'] = $this->groupList[$this->modes]['created_at'] ?? '';
            $group['updated_at'] = $this->groupList[$this->modes]['updated_at'] ?? '';
            $this->groupList[$this->modes] = $group;
        }
        $this->reset(['group_title','filters']);
        $this->resetErrorBag();
        $this->emitHideModal('newGroup');
    }

    public function addFilter()
    {
        $this->i = $this->i + 1;
        array_push($this->filters , $this->i);
    }

    public function hide($id)
    {
        $this->reset(['group_title','filters']);
        $this->resetErrorBag();
        $this->emitHideModal($id);
    }

    public function deleteFilter($key)
    {
        if ($this->modes <> 'new')
        {
            $id = $this->groupList[$this->modes]['filters'][$key]['id'];
            $id ? Filter::find($id)->delete() : '';
        }
        unset($this->filters[$key]);
    }

    public function deleteGroup($id)
    {
        $key = $this->groupList[$id]['id'];
        $key ? FilterGroup::find($key)->delete() : '';
        unset($this->groupList[$id]);
    }

    public function mount($action , $id = null)
    {
        $this->authorize('show_categories');

        if ($action === 'edit')
        {
            // set edit mode
            $this->header = 'دسته '.$id;

            $this->category = Category::findOrFail($id);
            $this->slug = $this->category->slug;
            $this->title = $this->category->title;
            $this->logo = $this->category->logo;
            $this->description = $this->category->description;
            $this->type = $this->category->type;
            $this->parent = $this->category->parent_id;
            $this->status = $this->category->status;
            $this->slider = $this->category->slider;
            $this->seo_description = $this->category->seo_description;
            $this->seo_keywords = $this->category->seo_keywords;
            $this->groupList = $this->category->groups()->with(['filters'])->get()->toArray();
            $this->data['category'] = Category::where([
                ['id','!=',$this->category->id]
            ])->pluck('title','id')->toArray();

        } else {
            // set create mode
            $this->header = 'دسته جدید';
            $this->data['category'] = Category::all()->pluck('title','id')->toArray();
        }


        $this->data['type'] = Category::type();
        $this->data['status'] = Category::getStatus();
        $this->mode = $action;
    }

    public function store()
    {
        $this->authorize('edit_categories');
        if ($this->mode == 'edit')
            $this->saveInDataBase($this->category);
        else {
            $this->saveInDataBase(new Category());
            $this->reset(['slug','title','logo','seo_description','seo_keywords','description','type',
                'parent','slider','group_title','filters']);
        }
    }

    public function saveInDataBase(Category $model)
    {
        $this->validate(
            [
                'slug' => ['required','max:255','string' , 'unique:categories,slug,'. ($this->category->id ?? 0)],
                'title' => ['required','max:255','string'],
                'logo' => ['nullable','string','max:255'],
                'description' => ['nullable','string','max:2000'],
                'seo_description' => ['required','string','max:250'],
                'seo_keywords' => ['required','string','max:250'],
                'type' => ['required','string','in:'.implode(',',array_keys(Category::type()))],
                'parent' => ['nullable','exists:categories,id'],
                'slider' => ['nullable','string','max:255'],
                'status' =>  ['required','string','in:'.implode(',',array_keys(Category::getStatus()))],
            ] , [] , [
                'slug' => 'نام مستعار',
                'title' => 'عنوان',
                'logo' => 'لوگو',
                'description' => 'توضیحات',
                'seo_keywords' => 'کلمات کلیدی',
                'seo_description' => 'توضیحات سئو',
                'type' => 'کاربری دسته ',
                'parent' => 'گروه مادر',
                'slider' => 'تصویر',
                'status' => 'وضعیت',
            ]
        );
        $model->slug = $this->slug;
        $model->title = $this->title;
        $model->logo = $this->logo;
        $model->description = $this->description;
        $model->seo_description = $this->seo_description;
        $model->seo_keywords = $this->seo_keywords;
        $model->type = $this->type;
        $model->parent_id = $this->parent ? $this->parent : null;
        $model->slider = $this->slider;
        $model->status = $this->status;
        $model->save();

        foreach ($this->groupList as $item)
        {
            $group = $item['id'] == 0 ? new FilterGroup() : FilterGroup::find($item['id']);
            $group->title = $item['title'];
            $group->category_id = $model->id;
            $group->save();
            foreach ($item['filters'] as $filter)
            {
                $filters = $filter['id'] == 0 ? new Filter() : Filter::find($filter['id']);
                $filters->group_id = $group->id;
                $filters->title = $filter['title'];
                $filters->save();
            }
        }
        if ($this->mode == 'edit')
            $this->groupList = $this->category->groups()->with(['filters'])->get()->toArray();
        $this->emitNotify('اطلاعات با موفقیت ثبت شد');

    }

    public function deleteItem()
    {
        $this->authorize('delete_categories');
        Category::findOrFail($this->category->id)->delete();
        return redirect()->route('admin.category');
    }

    public function render()
    {
        return view('livewire.admin.categories.store-category')->extends('livewire.admin.layouts.admin');
    }
}
