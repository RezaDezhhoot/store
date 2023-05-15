<?php

namespace App\Http\Livewire\Admin\Products;

use App\Http\Livewire\BaseComponent;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Traits\Admin\FormBuilder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;


/**
 * @method emptyToNull($short_description)
 */
class StoreProduct extends BaseComponent
{
    use AuthorizesRequests,FormBuilder;
    public $header , $product , $data = [],$mode;

    public $title, $slug, $short_description, $description, $price , $quantity, $image = []
    , $score, $status, $category_id,
        $discount_type, $discount_amount, $start_at, $expire_at,
        $seo_keyword, $seo_description , $media , $guarantee , $details;

    public $parameters = [],$parametersValue = [] , $hidden = true  , $filter_groups = [] , $selectedFilters = [];
    public function mount($action , $id = 'null')
    {
        $this->authorize('show_products');
        if ($action == 'edit'){
            $this->product = Product::findOrFail($id);
            $this->slug = $this->product->slug;
            $this->seo_keyword = $this->product->seo_keyword;
            $this->seo_description = $this->product->seo_description;
            $this->title = $this->product->title;
            $this->short_description = $this->product->short_description;
            $this->description = $this->product->description;
            $this->details = $this->product->details;
            $this->price = $this->product->price;
            $this->discount_type = $this->product->discount_type;
            $this->discount_amount = $this->product->discount_amount;
            $this->start_at = $this->product->start_at;
            $this->expire_at = $this->product->expire_at;
            $this->status = $this->product->status;
            $this->image = $this->product->image;
            $this->category_id  = $this->product->category_id ;
            $this->score  = $this->product->score ;
            $this->media  = $this->product->media ;
            $this->form  = $this->product->form ;
            $this->quantity  = $this->product->quantity ;
            $this->header = $this->title;
            $this->guarantee = $this->product->guarantee;
            $this->selectedFilters = $this->product->filters->pluck('pivot', 'group_id')->toArray();
        } else
            $this->header = 'محصول جدید';

        $this->data['type'] = Product::getProductsType();
        $this->data['status'] = Product::getStatus();
        $this->data['category_id'] = Category::where([
            ['type',Category::PRODUCT],
            ['status',Category::AVAILABLE]
        ])->pluck('title', 'id');
        $this->data['discount_type'] = Product::getProductsDiscount();
        $this->mode = $action;
    }

    public function render()
    {
        if (isset($this->category_id))
            $this->filter_groups = Category::find($this->category_id)->groups()->with(['filters'])->get();
        return view('livewire.admin.products.store-product')
            ->extends('livewire.admin.layouts.admin');
    }

    public function store()
    {
        $this->authorize('edit_products');
        if ($this->mode == 'edit')
            $this->saveInDataBase($this->product);
        elseif ($this->mode == 'create')
        {
            $this->saveInDataBase(new Product());
            $this->resetInputs();
        }
    }

    public function saveInDataBase(Product $product)
    {
        $this->validate(
            [
                'title' => ['required', 'string', 'max:250'],
                'slug' => ['required', 'string', 'unique:products,slug,' . ($this->product->id ?? 0)],
                'short_description' => ['nullable', 'string', 'max:65500'],
                'description' => ['nullable', 'string', 'max:4000000000'],
                'details' => ['nullable', 'string', 'max:4000000000'],
                'price' => ['required', 'between:0,999999999.999'],
                'quantity' => ['required', 'integer', 'min:0', 'max:65000'],
                'image' => ['required', 'string', 'max:250'],
                'media' => ['nullable', 'string', 'max:6500'],
                'score' => ['required', 'integer', 'min:0', 'max:65000'],
                'status' => ['required', 'in:' . Product::STATUS_DRAFT . ',' . Product::STATUS_AVAILABLE . ',' . Product::STATUS_UNAVAILABLE . ',' . Product::STATUS_COMING_SOON],
                'form' => ['present', 'array'],
                'category_id' => ['nullable', 'exists:categories,id'],
                'discount_type' => ['nullable', 'in:' . Product::DISCOUNT_FIXED . ',' . Product::DISCOUNT_PERCENTAGE],
                'discount_amount' => ['nullable', 'integer', 'min:0', 'max:1500000'],
                'start_at' => ['nullable', 'date'],
                'expire_at' => ['nullable', 'date'],
                'seo_keyword' => ['required', 'string', 'max:65500'],
                'seo_description' => ['required', 'string', 'max:250'],
                'guarantee' => ['required', 'integer', 'between:0,10000'],
            ],
            [],
            [
                'title' => 'عنوان',
                'slug' => 'آدرس',
                'short_description' => 'توضیحات کوتاه',
                'description' => 'توضیحات',
                'details' => 'مشخصات فنی',
                'currency_id' => 'واحد پول',
                'price' => 'قیمت',
                'quantity' => 'تعداد',
                'image' => 'تصویر',
                'media' => 'تصاویر',
                'score' => 'امتیاز',
                'type' => 'نوع',
                'status' => 'وضعیت',
                'form' => 'فرم',
                'category_id' => 'دسته بندی',
                'discount_type' => 'نوع تخفیف',
                'discount_amount' => 'مقدار تخفیف',
                'start_at' => 'شروع تخفیف',
                'expire_at' => 'پایان تخفیف',
                'seo_keyword' => 'کلمات کلیدی سئو',
                'seo_description' => 'توضیحات سئو',
                'guarantee' => 'گارانتی',
            ]
        );

        DB::transaction(function () use ($product) {
            $product->title = $this->title;
            $product->slug = $this->slug;
            $product->short_description = $this->short_description ?? null;
            $product->description = $this->description ?? null;
            $product->details = $this->details ?? null;
            $product->price = $this->price;
            $product->quantity = $this->quantity ?? null;
            $product->image = $this->image;
            $product->media = $this->media ?? null;
            $product->score = $this->score;
            $product->status = $this->status;
            $product->form = json_encode($this->form);
            $product->category_id = $this->category_id;
            $product->discount_type = $this->discount_type;
            $product->discount_amount = $this->discount_amount;
            $product->start_at = $this->start_at ?? null;
            $product->expire_at = $this->expire_at ?? null;
            $product->seo_keyword = $this->seo_keyword;
            $product->seo_description = $this->seo_description;
            $product->guarantee = $this->guarantee;
            $product->save();
        });

        $filters = [];
        if (!is_null($this->selectedFilters)) {
            foreach ($this->selectedFilters as $key => $item) {
                if(!empty($item['filter_id'])){
                    $filters[] = [
                        'product_id' =>  $product->id,
                        'filter_id' =>  $item['filter_id'],
                        'group_id' => $key
                    ];
                }
            }
        }

        if($this->mode == 'edit')
            $product->filters()->sync($filters);
        elseif($this->mode == 'create')
            $product->filters()->attach($filters);


        $this->emitNotify('اطلاعات با موفقیت ثبت شد');
        return $product->id;
    }

    public function deleteItem()
    {
        $this->authorize('delete_products');
        Comment::where([
            ['commentable_type',Comment::PRODUCT],
            ['commentable_id',$this->product->id],
        ])->delete();
        Product::findOrFail($this->product->id)->delete();
        return redirect()->route('admin.product');
    }

    public function resetInputs()
    {
        $this->reset(['title', 'slug', 'short_description', 'description', 'price',
             'quantity', 'image', 'media', 'score', 'status', 'category_id',
             'discount_type', 'discount_amount', 'start_at', 'expire_at', 'seo_keyword',
            'seo_description','guarantee','details']);
    }
}
