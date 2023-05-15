<div>
    <x-admin.form-control deleteAble="true" deleteContent="حذف کامنت" mode="{{$mode}}" title="کامنت"/>
    <div class="card card-custom gutter-b example example-compact">
        <x-admin.forms.validation-errors/>
        <div class="card-body">
            <x-admin.forms.dropdown id="commentable_type" disabled :data="$data['type']" label="نوع" wire:model.defer="commentable"/>
            <x-admin.forms.input type="text" disabled id="target" label="مورد" wire:model.defer="target"/>
            <x-admin.forms.dropdown id="status" :data="$data['status']" label="وضعیت*" wire:model.defer="status"/>
            <x-admin.forms.text-area label="نظر*"  wire:model.defer="text" id="text" />
            <x-admin.forms.text-area label="پاسخ*"  wire:model.defer="answer" id="answer" />
            <x-admin.forms.input type="number" id="rating" label="امتیاز*" wire:model.defer="rating"/>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: 'حذف کامنت!',
                text: 'آیا از حذف این کامنت اطمینان دارید؟',
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
                            'کامنت مورد نظر با موفقیت حذف شد',
                        )
                    }
                @this.call('deleteItem', id)
                }
            })
        }
    </script>
@endpush
