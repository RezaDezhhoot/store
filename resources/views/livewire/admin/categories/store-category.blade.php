<div>
    <x-admin.form-control deleteAble="true" deleteContent="حذف دسته" mode="{{$mode}}" title="دسته"/>
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body">
            <x-admin.forms.input type="text" id="slug" label="نام مستعار*" wire:model.defer="slug"/>
            <x-admin.forms.input type="text" id="title" label="عنوان*" wire:model.defer="title"/>
            <x-admin.forms.dropdown id="parent" :data="$data['category']" label="گروه مادر" wire:model.defer="parent"/>
            <x-admin.forms.dropdown id="status" :data="$data['status']" label="وضعیت*" wire:model.defer="status"/>
            <x-admin.forms.lfm-standalone id="logo" label="لوگو" :file="$logo" type="image" required="true" wire:model="logo"/>
            <x-admin.forms.lfm-standalone id="slider" label="تصویر" :file="$slider" type="image" required="true" wire:model="slider"/>
            <x-admin.forms.text-area label="کلمات کلیدی*" help="کلمات را با کاما از هم جدا کنید" wire:model.defer="seo_keywords" id="seo_keywords" />
            <x-admin.forms.text-area label="توضیحات سئو*" wire:model.defer="seo_description" id="seo_description" />
            <x-admin.forms.full-text-editor id="description" label="توضیحات" wire:model.defer="description"/>
            <x-admin.forms.dropdown id="type" :data="$data['type']" label="کاربری دسته*" wire:model.defer="type"/>
            <x-admin.form-section label="گروه فیلتر ها">
                <button wire:click.prevent="addGroup('new')" class="btn btn-light-primary font-weight-bolder btn-sm">افزودن</button>
                <table id="datatable-responsive" class="table table-striped">
                    <thead>
                    <tr>
                        <th> عنوان</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($groupList as $key => $item)
                        <tr>
                            <td>{{ $item['title'] }}</td>
                            <td>
                                <button type="button" wire:click="addGroup('{{$key}}')" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "></path>
                                                <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                            </g>
                                        </svg>
                                    </span>
                                </button>
                                <x-admin.delete-btn onclick="deleteGroup({{$key}})" />
                            </td>
                        </tr>
                    @empty
                        <td class="text-center" colspan="6">
                            دیتایی جهت نمایش وجود ندارد
                        </td>
                    @endforelse
                    </tbody>
                </table>
            </x-admin.form-section>
        </div>
    </div>
    <x-admin.modal-page id="newGroup" size="modal-xl" title="{{$modal_title}}"  wire:click="storeGroup()">
        <div class="col-12">
            <x-admin.forms.validation-errors/>
            <x-admin.forms.input type="text" id="group_title" label="عنوان" required="true" wire:model.defer="group_title" />
        </div>
        <div class="col-lg-12">
            <div class="col-12">
                <button type="button" class="btn btn-primary" wire:click="addFilter()">افزودن فیلتر</button>
            </div>
            <div class="col-12 p-4">
                @foreach($filters as $key => $item)
                    <div class="form-group" style="display: flex;align-items: center;border: 1px #d9d9d9 solid;">
                        <div class="col-md-10" style="display: flex;align-items: center">
                            <label for="">عنوان فیلتر</label>
                            <input type="text" wire:model.defer="filters.{{$key}}.title" class="form-control">
                            <input type="hidden" wire:model.defer="filters.{{$key}}.id" class="form-control">
                        </div>
                        <div  class="col-md-2">
                            <button type="button" class="btn btn-danger" wire:click="deleteFilter({{$key}})">حذف این فیلتر</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-admin.modal-page>
</div>
@push('scripts')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: 'حذف دسته  !',
                text: 'آیا از حذف این دسته اطمینان دارید؟',
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
                            'دسته  مورد نظر با موفقیت حذف شد',
                        )
                    }
                @this.call('deleteItem', id)
                }
            })
        }
        function deleteGroup(id) {
            Swal.fire({
                title: 'حذف گروه',
                text: 'آیا از حذف این  گروه دارید؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله'
            }).then((result) => {
                if (result.value) {
                @this.call('deleteGroup', id)
                }
            })
        }
    </script>
@endpush
