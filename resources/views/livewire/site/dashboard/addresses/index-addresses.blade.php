<div>
    <x-site.breadcrumbs :data="$address" />
    <section class="main_content_area">
        <div class="container">
            <div class="account_dashboard">
                <div class="row">
                    @include('livewire.site.dashboard.layouts.sidebar')
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade show active" id="dashboard">
                                <h3 class="text-dark-75">
                                    ادرس ها
                                </h3>
                                <a class="btn btn-link" href="{{ route('user.address',['create']) }}">افزودن ادرس جدید</a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>شهر</th>
                                            <th>ادرس</th>
                                            <th>کد پستی</th>
                                            <th>وضعیت</th>
                                            <th>عملیات</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-black">
                                        @foreach($addresses as $key=> $item)
                                            <tr>
                                                <td>{{ $item->city_label }}</td>
                                                <td>{{ $item->address }}</td>
                                                <td>{{ $item->postal_code }}</td>
                                                <td>{{ $item->active ? 'ادرس پیشفرض' : 'فعال' }}</td>
                                                <td>
                                                    @if(!$item->active)
                                                        <a wire:click="setDefault({{$item->id}})">تنظیم به عنوان ادرس پیشفرض</a>
                                                        <br>
                                                    @endif
                                                    <a onclick="deleteItem('{{$item->id}}')">حذف این ادرس</a>
                                                    <br>
                                                    <a href="{{ route('user.address',['edit',$item->id]) }}">ویرایش</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{$addresses->links('livewire.site.layouts.site.paginate')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@push('scripts')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: 'حذف ادرس!',
                text: 'آیا از حذف این ادرس اطمینان دارید؟',
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
                            'ادرس مورد نظر با موفقیت حذف شد',
                        )
                    }
                @this.call('delete', id)
                }
            })
        }
    </script>
@endpush
