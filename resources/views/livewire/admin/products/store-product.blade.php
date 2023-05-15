<div>
    {{--for text & textArea--}}
    <x-admin.modal-page id="text" size="modal-xl" title="{{$form[$formKey]['type'] ?? ''}}" wire:click="setFormData()" >
        <div>
            <x-admin.forms.validation-errors/>
        </div>
        <x-admin.forms.input type="text" id="text-name" label="name" wire:model.defer="formName" disabled/>
        <x-admin.forms.dropdown id="text-required" label="اجباری*" :data="['0' => 'خیر', '1' => 'بله']"  wire:model.defer="formRequired"/>
        <x-admin.forms.dropdown id="text-width" label="عرض*" :data="['1' => '50 درصد', '2' => '100 درصد']"  wire:model.defer="formWidth"/>
        <x-admin.forms.full-text-editor id="text" label="نام فیلد*" wire:model.defer="formLabel"/>
        <x-admin.forms.input type="text" id="text-placeholder" label="متن کمکی" wire:model.defer="formPlaceholder"/>
        <x-admin.forms.input type="text" id="text-value" label="مقدار پیش فرض" wire:model.defer="formValue"/>
        <x-admin.forms.form-conditions id="text" :conditions="$formConditions ?? []" :formKey="$formKey"/>
    </x-admin.modal-page>

    {{--for select & radio & customRadio && speedPlus--}}
    <x-admin.modal-page id="select" size="modal-xl" title="{{$form[$formKey]['type'] ?? ''}}" wire:click="setFormData()">
        <div>
            <x-admin.forms.validation-errors/>
        </div>
        <x-admin.forms.input type="text" id="select-name" label="name" wire:model.defer="formName" disabled/>
        <x-admin.forms.dropdown id="select-required" label="اجباری*" :data="['0' => 'خیر', '1' => 'بله']" required="true" wire:model.defer="formRequired"/>
        <x-admin.forms.dropdown id="select-width" label="عرض*" :data="['1' => '50 درصد', '2' => '100 درصد']" required="true" wire:model.defer="formWidth"/>
        <x-admin.forms.full-text-editor id="select" label="نام فیلد*"  wire:model.defer="formLabel"/>
        <x-admin.forms.input type="text" id="select-value" label="مقدار پیش فرض" wire:model.defer="formValue"/>
        <x-admin.forms.form-options :options="$formOptions ?? []" :formKey="$formKey"/>
        <x-admin.forms.form-conditions id="select" :conditions="$formConditions ?? []" :formKey="$formKey"/>
    </x-admin.modal-page>

    {{--for paragraph--}}
    <x-admin.modal-page id="paragraph" size="modal-xl" title="{{$form[$formKey]['type'] ?? ''}}" wire:click="setFormData()">
        <div>
            <x-admin.forms.validation-errors/>
        </div>
        <x-admin.forms.input type="text" id="paragraph-name" label="name" wire:model.defer="formName" disabled/>
        <x-admin.forms.full-text-editor id="paragraph" label="نام فیلد*"  wire:model.defer="formLabel"/>
        <x-admin.forms.form-conditions id="paragraph" :conditions="$formConditions ?? []" :formKey="$formKey"/>
    </x-admin.modal-page>

    <x-admin.form-control deleteAble="true" deleteContent="حذف محصول" mode="{{$mode}}" title="محصولات"/>
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body">
            <x-admin.forms.input type="text" id="title" label="عنوان*" wire:model.defer="title"/>
            <x-admin.forms.input type="text" id="slug" label="نام مستعار*" wire:model.defer="slug"/>
            <x-admin.forms.full-text-editor id="short_description" label="توضیحات کوتاه" wire:model.defer="short_description"/>
            <x-admin.forms.full-text-editor id="description" label="توضیحات" wire:model.defer="description"/>
            <x-admin.forms.full-text-editor id="details" label="مشخصات فنی" wire:model.defer="details"/>
            <x-admin.forms.input type="number" id="price" label="قیمت*" help="تومان" wire:model.defer="price"/>
            <x-admin.forms.input type="number" id="quantity" label="تعداد" help="درصورت خالی بودن محدودیتی اعمال نمیشود" wire:model.defer="quantity"/>
            <x-admin.forms.lfm-standalone id="image" label="تصویر*" :file="$image" type="image" wire:model="image"/>
            <x-admin.forms.lfm-standalone id="media" label="تصاویر" :file="$media" type="image" wire:model="media"/>
            <x-admin.forms.input type="number" id="score" label="امتیاز*"  wire:model.defer="score"/>
            <x-admin.forms.input type="number" id="guarantee" help="برحسب روز" label="مدت گارانتی*"  wire:model.defer="guarantee"/>
            <x-admin.forms.dropdown id="status" label="وضعیت*" :data="$data['status']"  wire:model.defer="status"/>
            <x-admin.forms.dropdown id="category_id" label="دسته" :data="$data['category_id']"  wire:model="category_id"/>

            <x-admin.form-section label="فیلتر ها">
                @foreach($filter_groups as $group)
                    <x-admin.forms.dropdown id="group{{$group->id}}" label="{{$group->title}}" :data="$group->filters()->pluck('title','id')"  wire:model.defer="selectedFilters.{{$group->id}}.filter_id"/>
                @endforeach
            </x-admin.form-section>

            <x-admin.forms.input type="text" id="seo_keyword" label="کلمات کلیدی سئو*" help="کلمات کلیدی را با کاما از هم جدا کنید" wire:model.defer="seo_keyword"/>
            <x-admin.forms.input type="text" id="seo_description" label="توضیحات سئو*"  wire:model.defer="seo_description"/>

            <x-admin.forms.dropdown id="discount_type" label="نوع تخفیف" :data="$data['discount_type']" required="true" wire:model.defer="discount_type"/>
            <x-admin.forms.input type="number" id="discount_amount" label="میزان تخفیف*"  wire:model.defer="discount_amount"/>
            <x-admin.forms.date-picker type="text" id="start_at" label="تاریخ شروع" help="در صورت خالی بودن محدودیتی در تاریخ شروع ندارد" wire:model.defer="start_at"/>
            <x-admin.forms.date-picker type="text" id="expire_at" label="تاریخ پایان" help="در صورت خالی بودن محدودیتی در انقضاء شروع ندارد" wire:model.defer="expire_at"/>
            <x-admin.form-section label="فرم ها">
                <button type="button" class="btn btn-link" wire:click="addForm('paragraph')">پاراگراف</button>
                <button type="button" class="btn btn-link" wire:click="addForm('customRadio')">انتخاب چندتایی</button>
                <button type="button" class="btn btn-link" wire:click="addForm('radio')">گزینه ای</button>
                <button type="button" class="btn btn-link" wire:click="addForm('select')">لیست</button>
                <button type="button" class="btn btn-link" wire:click="addForm('textArea')">متن طونی</button>
                <button type="button" class="btn btn-link" wire:click="addForm('text')">متن</button>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody wire:sortable="updateFormPosition()">
                        @forelse($form as $key => $item)
                            <tr wire:sortable.item="{{ $item['name'] }}" wire:key="{{ $item['name'] }}">
                                <td wire:sortable.handle>{{ $item['position'] }}</td>
                                <td>{!! $item['label'] ?? ''!!}</td>
                                <td>
                                    <button type="button" wire:click="editForm({{$key}})" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2">
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
                                    <x-admin.delete-btn onclick="deleteFormItem({{$key}})" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="3">
                                    دیتایی جهت نمایش وجود ندارد
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </x-admin.form-section>
        </div>
    </div>

</div>
@push('scripts')
    <script>
        function deleteFormItem(id) {
            Swal.fire({
                title: 'حذف فرم!',
                text: 'آیا از حذف فرم اطمینان دارید؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله'
            }).then((result) => {
                if (result.value) {
                @this.call('deleteForm', id)
                }
            })
        }
    </script>
    @push('scripts')
        <script>
            function deleteItem(id) {
                Swal.fire({
                    title: 'حذف محصول!',
                    text: 'آیا از حذف این محصول اطمینان دارید؟',
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
                                'محصول مورد نظر با موفقیت حذف شد',
                            )
                        }
                    @this.call('deleteItem', id)
                    }
                })
            }
        </script>
    @endpush

@endpush
