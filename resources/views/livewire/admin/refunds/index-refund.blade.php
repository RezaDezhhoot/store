<div>
    <x-admin.form-control store="{{false}}" title="مرجوعی ها"/>
    <div class="card card-custom">
        <div class="card-body">
            <x-admin.forms.dropdown id="status" :data="$data['status']" label="وضیعت" wire:model="status"/>
            @include('livewire.admin.layouts.advance-table')
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table  class="table table-striped" id="kt_datatable">
                        <thead>
                        <tr>
                            <th>کد پیگیری سفارش</th>
                            <th>محصول</th>
                            <th>تعداد</th>
                            <th>وضعیت</th>
                            <th>مبلغ کل</th>
                            <th>تاریخ</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($refunds as $item)
                            <tr>
                                <td>{{ $item->order->tracking_code }}</td>
                                <td>{{ $item->order->product->title }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->status_label }}</td>
                                <td>{{ number_format($item->order->price) }} تومان</td>
                                <td>{{ $item->date }}</td>
                                <td>
                                    <x-admin.edit-btn href="{{ route('admin.store.refund',['edit', $item->id]) }}" />
                                    <x-admin.delete-btn onclick="deleteItem({{$item->id}})" />
                                </td>
                            </tr>
                        @empty
                            <td class="text-center" colspan="7">
                                دیتایی جهت نمایش وجود ندارد
                            </td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{$refunds->links('livewire.admin.layouts.paginate')}}
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: 'حذف مرجوعی!',
                text: 'آیا از حذف این مرجوعی اطمینان دارید؟',
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
                            'مرجوعی مورد نظر با موفقیت حذف شد',
                        )
                    }
                @this.call('delete', id)
                }
            })
        }
    </script>
@endpush
