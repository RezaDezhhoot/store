<div>
    <x-admin.form-control deleteAble="true" deleteContent="حذف کد تخفیف" mode="{{$mode}}" title="کد های تخفیف"/>
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body">
            <x-admin.forms.input id="code" type="text" label="کد*"  wire:model.defer="code"/>
            <x-admin.forms.text-area id="description" label="توضیحات" wire:model="description"/>
            <x-admin.forms.dropdown id="type" label="نوع*" :data="$data['type']"  wire:model.defer="type"/>
            <x-admin.forms.input id="amount" type="number" label="مقدار*"  wire:model.defer="amount"/>
            <x-admin.forms.date-picker id="starts_at" label="تاریخ شروع" wire:model.defer="starts_at"/>
            <x-admin.forms.date-picker id="expires_at" label="تاریخ پایان" wire:model.defer="expires_at"/>
            <x-admin.forms.input id="minimum_amount" type="number" label="حداقل میزان خرید" wire:model.defer="minimum_amount"/>
            <x-admin.forms.input id="maximum_amount" type="number" label="حداکثر میزان خرید" wire:model.defer="maximum_amount"/>
            <x-admin.forms.input id="value_limit" type="number" label="حداکثر مقدار تخفیف" wire:model.defer="value_limit"/>
            <x-admin.forms.input id="product_ids" type="text" label="محصولات مجاز" help="ایدی ها با کاما جدا کنید" wire:model.defer="product_ids"/>
            <x-admin.forms.input id="exclude_product_ids" type="text" label="محصولات غیرمجاز" help="ایدی ها با کاما جدا کنید" wire:model.defer="exclude_product_ids"/>
            <x-admin.forms.checkbox id="exclude_sale_items" label="محصولات دارای تخفیف" value="1" wire:model.defer="exclude_sale_items" />
            <x-admin.forms.input id="category_ids" type="text" label="دسته بندی های مجاز" help="ایدی ها با کاما جدا کنید" wire:model.defer="category_ids"/>
            <x-admin.forms.input id="exclude_category_ids" type="text" label="دسته بندی های غیرمجاز" help="ایدی ها با کاما جدا کنید" wire:model.defer="exclude_category_ids"/>
            <x-admin.forms.input id="usage_limit" type="number" label="حداکثر استفاده" wire:model.defer="usage_limit"/>
            <x-admin.forms.input id="usage_limit_per_user" type="number" label="حداکثر استفاده برای کاربر" wire:model.defer="usage_limit_per_user"/>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: 'حذف کد تخفیف  !',
                text: 'آیا از حذف این کد تخفیف اطمینان دارید؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله'
            }).then((result) => {
                if (result.value) {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'موفیت امیز!',
                            'کد تخفیف  مورد نظر با موفقیت حذف شد',
                        )
                    }
                @this.call('deleteItem', id)
                }
            })
        }
    </script>
@endpush
