<div>
    <x-admin.form-control deleteAble="true" deleteContent="حذف مرجوعی" mode="{{$mode}}" title="مرجوعی"/>
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body">
            <x-admin.form-section label="مشاهده سفارش">
                <a href="{{ route('admin.store.order',['edit',$refund->order->id]) }}">
                    {{ $refund->order->product->title }}
                </a>
            </x-admin.form-section>
            <x-admin.forms.full-text-editor id="content" label="توضیحات*" wire:model.defer="content"/>
            <x-admin.forms.input type="text" id="quantity" disabled label="تعداد" value="{{$refund->quantity}}" />
            <x-admin.forms.lfm-standalone id="images" label="تصاویر*" :file="$images" type="image" required="true" wire:model="images"/>
            <x-admin.forms.dropdown id="status" :data="$data['status']" label="وضعیت*" wire:model.defer="status"/>
            <x-admin.forms.input type="text" id="card_number" disabled label="شماره کارت خریدار" value="{{$refund->card_number}}" />
            <x-admin.forms.input type="text" id="sheba_number" disabled label="شماره شبا خریدار" value="{{$refund->sheba_number}}" />
            <x-admin.forms.input type="text" id="name" disabled label="نام خریدار" value="{{$refund->name}}" />
            <x-admin.forms.full-text-editor id="result" label="نتیجه" wire:model.defer="result"/>
        </div>
    </div>
</div>
