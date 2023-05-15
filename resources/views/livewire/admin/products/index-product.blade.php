<div>
    <x-admin.form-control link="{{ route('admin.store.product',['create'] ) }}" title="محصولات"/>
    <div class="card card-custom">
        <div class="card-body">
            @include('livewire.admin.layouts.advance-table')
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>شماره</th>
                            <th>عنوان</th>
                            <th>دسته</th>
                            <th>قیمت</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->title}}</td>
                                <td>{{$item->category->title ?? ''}}</td>
                                <td>{{number_format($item->price)}} تومان</td>
                                <td>{{$item->status_label}}</td>
                                <td>
                                    <x-admin.edit-btn href="{{ route('admin.store.product',['edit', $item->id]) }}" />
                                    <x-admin.delete-btn onclick="deleteItem({{$item->id}})" />
                                </td>
                            </tr>
                        @empty
                            <td class="text-center" colspan="5">
                                دیتایی جهت نمایش وجود ندارد
                            </td>
                        @endforelse
                        <tr>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $products->links('livewire.admin.layouts.paginate') }}
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: 'حذف محصول!',
                text: 'آیا از حذف محصول اطمینان دارید؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله'
            }).then((result) => {
                if (result.value) {
                @this.call('delete', id)
                }
            })
        }
    </script>
@endpush
