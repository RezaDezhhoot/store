<div>
    <x-admin.form-control deleteAble="true" deleteContent="حذف سفارش" mode="{{$mode}}" title="سفارش"/>
    <div class="card card-custom gutter-b example example-compact">
        <x-admin.forms.validation-errors/>
        <div class="card-body">
            <x-admin.form-section label="کاربر">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <td>نام</td>
                                <td>نام کاربری</td>
                                <td>شماره همراه</td>
                                <td>وضعیت</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->user->user_name }}</td>
                                <td>{{ $order->user->phone }}</td>
                                <td>{{ $order->user->status_label }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-admin.form-section>
            <x-admin.form-section label="سبد سفارش">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <td>نام:</td>
                                <td>شماره:</td>
                                <td>کد پیگیری سبد:</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$order->name}}</td>
                                <td>{{$order->phone}}</td>
                                <td>{{$order->tracking_code}}</td>
                            </tr>
                            </tbody>
                            <thead>
                            <tr>
                                <td>استان:</td>
                                <td>شهر:</td>
                                <td>کد پستی:</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{\App\Models\Setting::getProvince()[$order->province]}}</td>
                                <td>{{\App\Models\Setting::getCity()[$order->province][$order->city]}}</td>
                                <td>{{$order->postal_code}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6 col-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <td>روش ارسال:</td>
                                <td>هزینه ارسال :</td>
                                <td>IP:</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$order->send->slug}}</td>
                                <td>{{number_format($order->send->price)}} تومان </td>
                                <td>{{$order->user_ip}}</td>
                            </tr>
                            </tbody>
                            <thead>
                            <tr>

                                <td>هزینه کل:</td>
                                <td>کیف پول :</td>
                                <td>هزینه پرداخت شده:</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{number_format($order->price)}}تومان </td>
                                <td>{{number_format($order->wallet_pay)}}تومان </td>
                                <td>{{number_format($order->total_price)}} تومان </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <td>آدرس کامل:</td>
                                <td>توضیحات خریدار:</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->description }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <td>کد تخفیف:</td>
                                <td>بابت کد تخفیف:</td>
                                <td>تخفیف محصولات:</td>
                                <td>تخفیف کل:</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ $order->reduction_code }}</td>
                                <td>{{ number_format($order->reductions_value - $order->discount) }} تومان </td>
                                <td>{{ number_format($order->discount) }} تومان </td>
                                <td>{{ number_format($order->reductions_value) }} تومان </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-admin.form-section>
            <x-admin.form-section label="جزییات سفارش">
               <div class="row">
                   @foreach($details as $key => $detail)
                       <div class="col-12 mt-3 p-4" style="border: 1px solid #eaeaea;border-radius: 10px;">
                           <h3> کد پیگیری سفارش: {{$detail->tracking_code}}</h3>
                           <table class="table  table-bordered">
                               <thead>
                               <tr>
                                   <td>نام محصول:</td>
                                   <td>تعداد:</td>
                                   <td>فرم ها:</td>
                                   <td>هزینه کل:</td>
                                   <td>هزینه پرداخت شده:</td>
                                   <td>وضعیت:</td>
                                   <td>عملیات:</td>
                               </tr>
                               </thead>
                               <tbody>
                               <tr>
                                   <td>{{ $detail->product->title }}</td>
                                   <td>{{ $detail->quantity }}</td>
                                   <td>
                                       @if(sizeof($detail->form) > 0)
                                           <div class="row">
                                               @foreach($detail->form as $form)
                                                   @if(($form['type'] ?? '') != 'paragraph')
                                                       <div class="form-group col-4">
                                                           {!! $form['label'] ?? '' !!}
                                                       </div>
                                                       <div class="form-group col-4">
                                                            {{$form['value'] ?? ''}}
                                                       </div>
                                                       <div class="form-group col-4">
                                                            {{number_format(($form['price'] ?? 0) * $detail->quantity)}} تومان
                                                       </div>
                                                   @endif
                                               @endforeach
                                           </div>
                                       @endif
                                   </td>
                                   <td>{{ number_format($detail->price) }}تومان  </td>
                                   <td>{{ number_format($detail->total_price) }}تومان  </td>
                                   <td>
                                       <div class="form-group">
                                           <x-admin.forms.dropdown id="status{{$detail->id}}" :data="$data['status']" label="وضعیت*" wire:model.defer="statuses.{{$detail->id}}"/>
                                       </div>
                                   </td>
                                   <td>
                                       <x-admin.delete-btn onclick="deleteDetail({{$key}})" />
                                   </td>
                               </tr>
                               </tbody>
                           </table>
                           @if(!empty($detail->refund) && !is_null($detail->refund))
                               <div class="col-12">
                                   <x-admin.form-section label="مرجوعیت این سفارش">
                                       <table class="table  table-bordered">
                                           <thead>
                                           <tr>
                                               <td>تعداد</td>
                                               <td>وضعیت</td>
                                               <td>تاریخ</td>
                                               <td>مشاهده</td>
                                           </tr>
                                           </thead>
                                           <tbody>
                                           <tr>
                                               <td>{{ $detail->refund->quantity }}</td>
                                               <td>{{ $detail->refund->status_label }}</td>
                                               <td>{{ $detail->refund->date }}</td>
                                               <td>
                                                   <x-admin.edit-btn href="{{ route('admin.store.refund',['edit', $detail->refund->id]) }}" />
                                               </td>
                                           </tr>
                                           </tbody>
                                       </table>
                                   </x-admin.form-section>
                               </div>
                           @endif
                           <div class="col-12">
                               <x-admin.form-section label="یادداشت های این سفارش">
                                   <table class="table  table-bordered">
                                       <thead>
                                       <tr>
                                           <td>یادداشت</td>
                                           <td>تاریخ</td>
                                           <td>کاربر</td>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       @if(sizeof($detail->note) > 0)
                                           @foreach($detail->note()->orderBy('id','desc')->get() as $note)
                                               <tr>
                                                   <td>{{ $note->note }}</td>
                                                   <td>{{ $note->date }}</td>
                                                   <td>{{ $note->user->name ?? 'سیستم' }}</td>
                                               </tr>
                                           @endforeach
                                       @endif
                                       </tbody>
                                   </table>
                               </x-admin.form-section>
                           </div>
                       </div>
                   @endforeach
               </div>
            </x-admin.form-section>
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
                @this.call('deleteItem', id)
                }
            })
        }

        function deleteDetail(id) {
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
                @this.call('deleteDetail', id)
                }
            })
        }
    </script>
@endpush
