<div>
    <x-admin.form-control store="{{false}}" title="سفارش ها"/>
    <div class="card card-custom">
        <div class="card-body">
            <x-admin.forms.dropdown id="status" :data="$data['status']" label="وضیعت" wire:model="status"/>
            @include('livewire.admin.layouts.advance-table')
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table  class="table table-striped" id="kt_datatable">
                        <thead>
                        <tr>
                            <th>کد پیگیری سبد</th>
                            <th>جزئیات</th>
                            <th>وضعیت</th>
                            <th>مبلغ کل</th>
                            <th>خریدار</th>
                            <th>تاریخ</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $item)
                            <tr>
                                <td>{{ $item->tracking_code }}</td>
                                <td>
                                    @foreach($item->details as $order)
                                        <div class="border-bottom-info border">
                                            <span class="d-block text-info">
                                            محصول:{{ $order->product->title }}
                                            <br>
                                            کد پیگیری سفارش :{{ $order->tracking_code }}
                                        </span>
                                        </div>
                                    @endforeach
                                </td>
                                <td>{{ $item->status_label }}</td>
                                <td>{{ number_format($item->price) }} تومان</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->date }}</td>
                                <td>
                                    <x-admin.edit-btn href="{{ route('admin.store.order',['edit', $item->id]) }}" />
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
            {{$orders->links('livewire.admin.layouts.paginate')}}
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: 'حذف سفارش!',
                text: 'آیا از حذف این سفارش اطمینان دارید؟',
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
                            'سفارش مورد نظر با موفقیت حذف شد',
                        )
                    }
                @this.call('delete', id)
                }
            })
        }
    </script>
@endpush
