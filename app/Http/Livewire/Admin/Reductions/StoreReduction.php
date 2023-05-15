<?php

namespace App\Http\Livewire\Admin\Reductions;

use App\Http\Livewire\BaseComponent;
use App\Models\Reduction;
use App\Models\ReductionMeta;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreReduction extends BaseComponent
{
    use AuthorizesRequests;
    public $header , $data = [] , $mode;

    public $code, $description, $type, $amount, $starts_at, $expires_at , $reduction;
    public $minimum_amount, $maximum_amount, $product_ids, $exclude_product_ids, $exclude_sale_items,
        $category_ids, $exclude_category_ids, $usage_limit, $usage_limit_per_user,$value_limit;

    public function mount($action , $id = null)
    {
        $this->authorize('show_reductions');
        if ($action == 'edit'){
            $this->reduction = Reduction::find($id);
            $this->header = $this->reduction->code;
            $meta = ReductionMeta::where('reduction_id', $this->reduction->id)->get();

            $this->code = $this->reduction->code;
            $this->description = $this->reduction->description;
            $this->type = $this->reduction->type;
            $this->amount = $this->reduction->amount;
            $this->starts_at = $this->reduction->starts_at;
            $this->expires_at = $this->reduction->expires_at;
            $this->minimum_amount = $meta->where('name', 'minimum_amount')->first()->value ?? '';
            $this->maximum_amount = $meta->where('name', 'maximum_amount')->first()->value ?? '';
            $this->product_ids = $meta->where('name', 'product_ids')->first()->value ?? '';
            $this->exclude_product_ids = $meta->where('name', 'exclude_product_ids')->first()->value ?? '';
            $this->exclude_sale_items = $meta->where('name', 'exclude_sale_items')->first()->value ?? '';
            $this->category_ids = $meta->where('name', 'category_ids')->first()->value ?? '';
            $this->exclude_category_ids = $meta->where('name', 'exclude_category_ids')->first()->value ?? '';
            $this->usage_limit = $meta->where('name', 'usage_limit')->first()->value ?? '';
            $this->usage_limit_per_user = $meta->where('name', 'usage_limit_per_user')->first()->value ?? '';
            $this->value_limit =  $meta->where('name', 'value_limit')->first()->value ?? '';
        } else
            $this->header = 'کد جدید';

        $this->data['type'] = Reduction::getType();
        $this->mode = $action;
    }

    public function render()
    {
        return view('livewire.admin.reductions.store-reduction')
            ->extends('livewire.admin.layouts.admin');
    }

    public function store()
    {
        $this->authorize('edit_reductions');
        if ($this->mode == 'edit')
            $this->saveInDatabase($this->reduction);
        elseif ($this->mode == 'create'){
            $this->saveInDatabase(new Reduction());
            $this->reset(['code','description','type','amount','starts_at','expires_at','minimum_amount','maximum_amount'
            ,'product_ids','exclude_product_ids','exclude_sale_items','category_ids','exclude_category_ids','usage_limit','usage_limit_per_user'
            ,'value_limit']);
        }
    }


    private function saveInDatabase(Reduction $voucher)
    {
        $this->validate(
            [
                'code' => ['required', 'string', 'max:250', 'unique:reductions,code,' . ($this->reduction->id ?? 0)],
                'description' => ['nullable', 'string', 'max:250'],
                'type' => ['required', 'string', 'max:250'],
                'amount' => ['required', 'integer', 'min:0'],
                'starts_at' => ['nullable', 'string', 'max:65500'],
                'expires_at' => ['nullable', 'string', 'max:250'],
                'minimum_amount' => ['nullable', 'integer', 'min:0'],
                'maximum_amount' => ['nullable', 'integer', 'min:0'],
                'product_ids' => ['nullable', 'string', 'max:250'],
                'exclude_product_ids' => ['nullable', 'string', 'max:250'],
                'exclude_sale_items' => ['nullable', 'boolean'],
                'category_ids' => ['nullable', 'string', 'max:250'],
                'exclude_category_ids' => ['nullable', 'string', 'max:250'],
                'usage_limit' => ['nullable', 'integer', 'min:0'],
                'usage_limit_per_user' => ['nullable', 'integer', 'min:0'],
                'value_limit' => ['nullable', 'integer', 'min:0'],
            ],
            [],
            [
                'code' => 'کد',
                'description' => 'توضیحات',
                'type' => 'نوع',
                'amount' => 'مقدار',
                'starts_at' => 'تاریخ شروع',
                'expires_at' => 'تاریخ انقضاء',
                'minimum_amount' => 'حداقل میزان خرید',
                'maximum_amount' => 'حداکثر میزان خرید',
                'product_ids' => 'محصولات مجاز',
                'exclude_product_ids' => 'محصولات غیرمجاز',
                'exclude_sale_items' => 'محصولات دارای تخفیف',
                'category_ids' => 'دسته بندی های مجاز',
                'exclude_category_ids' => 'دسته بندی های غیرمجاز',
                'usage_limit' => 'حداکثر استفاده',
                'usage_limit_per_user' => 'حداکثر استفاده برای کاربر',
                'value_limit' => 'حداکثر مقدار تخفیف ',
            ]
        );

        $voucher->code = $this->code;
        $voucher->description = $this->description;
        $voucher->type = $this->type;
        $voucher->amount = $this->amount;
        $voucher->starts_at = $this->starts_at;
        $voucher->expires_at = $this->expires_at;
        $voucher->save();

        $meta = [
            'minimum_amount' => $this->minimum_amount,
            'maximum_amount' => $this->maximum_amount,
            'product_ids' => $this->product_ids,
            'exclude_product_ids' => $this->exclude_product_ids,
            'exclude_sale_items' => $this->exclude_sale_items,
            'category_ids' => $this->category_ids,
            'exclude_category_ids' => $this->exclude_category_ids,
            'usage_limit' => $this->usage_limit,
            'usage_limit_per_user' => $this->usage_limit_per_user,
            'value_limit' => $this->value_limit,
        ];

        foreach ($meta as $key => $item) {
            if (is_null($item) || $item == '') {
                ReductionMeta::where('reduction_id', $voucher->id)
                    ->where('name', $key)
                    ->delete();
            } else {
                ReductionMeta::updateOrCreate(
                    ['reduction_id' => $voucher->id, 'name' => $key],
                    ['value' => $item]
                );
            }
        }

        $this->emitNotify('اطلاعات با موفقیت ثبت شد');
    }

    public function deleteItem($id)
    {
        $this->authorize('delete_reductions');
        Reduction::findOrFail($this->reduction->id)->delete();
        return redirect()->route('admin.reduction');
    }


}
