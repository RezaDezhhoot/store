<div>
    <x-admin.form-control link="{{ route('admin.store.faq',['create'] ) }}" title="سوالات متداول"/>
    <div class="card card-custom">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table  class="table table-striped" id="kt_datatable">
                        <thead>
                        <tr>
                            <th>سوال</th>
                            <th> جواب</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($faq as $item)
                            <tr>
                                <td>{!!  $item->value['question'] !!} </td>
                                <td>{!! $item->value['answer'] !!}</td>
                                <td>
                                    <x-admin.edit-btn href="{{ route('admin.store.faq',['edit', $item->id]) }}" />
                                    <x-admin.delete-btn onclick="deleteItem({{$item->id}})" />
                                </td>
                            </tr>
                        @empty
                            <td class="text-center" colspan="6">
                                دیتایی جهت نمایش وجود ندارد
                            </td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{$faq->links('livewire.admin.layouts.paginate')}}
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: 'حذف سوال!',
                text: 'آیا از حذف سوال اطمینان دارید؟',
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
