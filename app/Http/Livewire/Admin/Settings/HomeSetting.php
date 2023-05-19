<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Http\Livewire\BaseComponent;
use Livewire\Component;
use App\Models\Setting;

class HomeSetting extends BaseComponent
{
    public $header , $content = [] , $i = 1 , $titleContent , $title , $type  , $width , $bgImage , $data , $moreLink , $widthCase;
    public $category , $bannerLink , $bannerImage , $contentCase = [] , $mode;
    public $titleSlider , $slider , $sliderImage , $sliderLink , $sliders , $modeSlider , $row , $view , $subtitle;

    public $homeAbout;

    public $homeImg1 , $homeImg2 , $homeImg3;

    public $services = [];

    public function mount()
    {
        $this->header = 'تنظیمات صفحه اصلی';
        $this->data['type'] = [
            'grid' => 'نمایش شبکه ای',
            'slider' => 'نمایش اسلایدری',
        ];
        $this->data['category'] = [
            'articles' => 'اخبار و مقالات',
            'products' => 'محصولات',
            'categories' => 'دسته بندی ها',
//            'comments' => 'نظرات مشتریان',
            'banners' => 'بنر تبلیغاتی',
        ];
        $this->data['row'] = [
            '1' => '1 ردیف',
            '2' => '2 ردیف',
            '3' => '3 ردیف',
        ];
        $this->data['width'] = [
            '1' => '8.33%',
            '2' => '16.66%',
            '3' => '25%',
            '4' => '33.33%',
            '5' => '41.66%',
            '6' => '50%',
            '7' => '58.33%',
            '8' => '66.66%',
            '9' => '75%',
            '10' => '83.33%',
            '11' => '91.66%',
            '12' => '100%',
        ];
//        $this->content = collect(Setting::getSingleRow('homeContent',[]));
        $this->sliders = Setting::getSingleRow('homeSlider');
        $this->slider = $this->sliders['slider'] ?? null;
        $this->subtitle = $this->sliders['subtitle'] ?? null;
        $this->sliderImage = $this->sliders['sliderImage'] ?? null;
        $this->sliderLink = $this->sliders['sliderLink'] ?? null;
        $this->homeAbout = Setting::getSingleRow('homeAbout');
        $this->homeImg1 = Setting::getSingleRow('homeImg1');
        $this->homeImg2 = Setting::getSingleRow('homeImg1');
        $this->homeImg3 = Setting::getSingleRow('homeImg3');
    }
    public function addContent($title)
    {
        if ($title <> 'new')
        {
            $this->titleContent = $this->content[$title]['title'];
            $this->view = $this->content[$title]['view'];
            $this->title = $this->content[$title]['title'];
            $this->moreLink = $this->content[$title]['moreLink'] ?? '';
            $this->category = $this->content[$title]['category'];
            $this->type = $this->content[$title]['type'] ?? '';
            if ($this->type == 'slider')
                $this->row = $this->content[$title]['row'];
            $this->width = $this->content[$title]['width'];
            $this->widthCase = $this->content[$title]['widthCase'] ?? '';

            $this->contentCase = $this->content[$title]['contentCase'] ?? [];
            $this->bannerImage = $this->content[$title]['bannerImage'] ?? '';
            $this->bannerLink = $this->content[$title]['bannerLink'] ?? '';
        } else {
            $this->reset(['title','moreLink','view','category','width','widthCase','row','type','contentCase','bannerImage','bannerLink']);
            $this->titleContent = 'محتوای جدید';
        }
        $this->mode = $title;
        $this->emitShowModal('content');
    }

    public function addContentCase()
    {
        array_push($this->contentCase,'');
    }

    public function storeContent()
    {
        $fields = [];
        $messages = [];
        if ($this->category <> 'banners')
        {
            $fields = [
                'title' => ['required', 'string'],
                'view' => ['required', 'integer'],
                'moreLink' => ['nullable', 'url'],
                'category' => ['required','string' ,'in:'.implode(',',array_keys($this->data['category']))],
                'width' => ['required', 'numeric','in:'.implode(',',array_keys($this->data['width']))],
                'type' => ['required','in:slider,grid'],
                'contentCase.*'=> ['required','numeric','exists:'.$this->category.',id'],
            ];
            $messages = [
                'title' => 'عنوان',
                'view' => 'شماره نمایش',
                'width' => 'عرض',
                'category' => 'نوع محتوا',
                'row' => 'تعداد ردیف',
                'type' => 'نوع نمایش',
                'widthCase' => 'عرض هر باکس',
                'moreLink' => 'لینک صفحه نمایش همه',
                'contentCase.*' => 'موارد'
            ];
            if ($this->type <> 'slider'){
                $fields['widthCase'] = ['required', 'numeric','in:'.implode(',',array_keys($this->data['width']))];
            }
            if ($this->type == 'slider'){
                $fields['row'] = ['required','in:'.implode(',',array_keys($this->data['row']))];
            }
            $this->validate($fields,[], $messages);
            $content = [
                'title' => $this->title,
                'view' => $this->view,
                'width' => $this->width,
                'row' => $this->row,
                'category' => $this->category,
                'type' => $this->type,
                'widthCase' => $this->widthCase,
                'moreLink' => $this->moreLink,
                'contentCase' => $this->contentCase
            ];
            $array = $this->content->toArray();
            if ($this->mode == 'new'){
                array_push($array,$content);
                $this->content = collect($array);
            }
            else $this->content[$this->mode] = $content;
        } else {
            $fields = [
                'title' => ['required', 'string'],
                'view' => ['required', 'integer'],
                'category' => ['required','string' ,'in:banners'],
                'width' => ['required', 'numeric','in:'.implode(',',array_keys($this->data['width']))],
                'bannerImage' => ['required', 'string'],
                'bannerLink' => ['nullable','url'],
            ];
            $messages = [
                'title' => 'عنوان',
                'view' => 'شماره نمایش',
                'width' => 'عرض',
                'category' => 'نوع محتوا',
                'bannerImage' => 'تسویر',
                'bannerLink' => 'لینک مورد نظر'
            ];

            $this->validate($fields,[], $messages);
            $content = [
                'title' => $this->title,
                'view' => $this->view,
                'width' => $this->width,
                'type' => 'grid',
                'category' => $this->category,
                'bannerImage' => $this->bannerImage,
                'bannerLink' => $this->bannerLink,
            ];
            $array = $this->content->toArray();
            if ($this->mode == 'new'){
                array_push($array,$content);
                $this->content = collect($array);
            }
            else $this->content[$this->mode] = $content;
        }
        $this->reset(['title','moreLink','view','category','width','widthCase','type','row','contentCase','bannerImage','bannerLink']);
        $this->hide('content');
    }

    public function hide($id)
    {
        $this->reset(['title','moreLink','view','category','width','widthCase','row','type','contentCase','bannerImage','bannerLink']);
        $this->resetErrorBag();
        $this->emitHideModal($id);
    }

    public function unSetCase($key)
    {
        unset($this->contentCase[$key]);
    }

    public function unSetContent($key)
    {
        unset($this->content[$key]);
    }

    public function addSlider($title)
    {
        $this->reset(['slider','sliderImage','sliderLink']);
        if ($title <> 'new')
        {
            $this->slider = $this->sliders[$title]['slider'];
            $this->sliderImage = $this->sliders[$title]['sliderImage'];
            $this->sliderLink = $this->sliders[$title]['sliderLink'];
        } else {
            $this->titleSlider = 'اسلایدر جدید';
        }
        $this->modeSlider = $title;
        $this->emitShowModal('slider');
    }

    public function storeSlider()
    {
        $fields = [
            'slider' => ['required', 'string'],
            'sliderImage' => ['required', 'string'],
            'sliderLink' => ['nullable','url'],
        ];
        $messages = [
            'slider' => 'عنوان',
            'sliderImage' => 'تصویر',
            'sliderLink' => 'لینک مورد نظر',
        ];
        $slider = [
            'slider' => $this->slider,
            'sliderImage' => $this->sliderImage,
            'sliderLink' => $this->sliderLink,
        ];
        $this->validate($fields,[], $messages);
        if ($this->modeSlider == 'new'){
            array_push($this->sliders,$slider);
        }
        else $this->sliders[$this->modeSlider] = $slider;

        $this->reset(['slider','sliderImage','sliderLink']);
        $this->hide('slider');

    }

    public function unSetSlider($key)
    {
        unset($this->sliders[$key]);
    }

    public function store()
    {
        $this->resetErrorBag();
        Setting::updateOrCreate(['name' => 'homeContent'], ['value' => json_encode($this->content)]);
        Setting::updateOrCreate(['name' => 'homeAbout'], ['value' => ($this->homeAbout)]);
        Setting::updateOrCreate(['name' => 'homeImg1'], ['value' => ($this->homeImg1)]);
        Setting::updateOrCreate(['name' => 'homeImg2'], ['value' => ($this->homeImg2)]);
        Setting::updateOrCreate(['name' => 'homeImg3'], ['value' => ($this->homeImg3)]);

        $this->sliders = [
            'slider' => $this->slider,
            'subtitle' => $this->subtitle,
            'sliderImage' => $this->sliderImage,
            'sliderLink' => $this->sliderLink
        ];
        Setting::updateOrCreate(['name' => 'homeSlider'], ['value' => json_encode($this->sliders)]);
        $this->emitNotify('اطلاعات با موفقیت ثبت شد');
    }

    public function render()
    {
        return view('livewire.admin.settings.home-setting')
            ->extends('livewire.admin.layouts.admin');
    }
}
