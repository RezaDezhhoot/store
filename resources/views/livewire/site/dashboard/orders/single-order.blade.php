<div>
    <div role="main" class="main shop">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 align-self-center order-1">
                        <x-site.breadcrumbs :data="$address" />
                    </div>
                </div>
            </div>
        </section>
        <section class="main_content_area">
            <div class="container">
                <div class="account_dashboard">
                    <div class="row">
                        @include('livewire.site.dashboard.layouts.sidebar')
                        <div class="col-sm-12 col-md-9 col-lg-9">
                            <!-- Tab panes -->
                            <div class="tab-content dashboard_content">
                                <div class="tab-pane fade show active" id="dashboard">
                                    <h4>سبد سفارش</h4>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <td>نام:</td>
                                                    <td>شماره:</td>
                                                    <td>کد پیگیری سبد سفارش:</td>
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
                                    <h5>جزییات سفارش</h5>
                                    <div class="row">
                                        @foreach($details as $key => $detail)
                                            <div class="col-12" >
                                                <h4>{{$key+1}}# - کد پیگیری سفارش : {{$detail->tracking_code}} </h4>
                                                <table class="table table-responsive-md table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <td>نام محصول:</td>
                                                        <td>تعداد:</td>
                                                        <td>اطلاعات :</td>
                                                        <td>هزینه:</td>
                                                        <td>وضعیت:</td>
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
                                                                            <div class=" col-12">
                                                                                {{$form['value'] ?? ''}}
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($detail->total_price) }}تومان  </td>
                                                        <td>
                                                            {{ $data['status'][$detail->status] }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-12">
                                                    <h4> یادداشت های این سفارش </h4>

                                                    <table class="table table-responsive-md table-striped table-bordered">
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

                                                </div>
                                                @if(is_null($detail->comment) && empty($detail->comment))
                                                    <div class="col-12">
                                                        <fieldset class="scheduler-border">
                                                            <legend class="scheduler-border">نظر خود را در باره این محصول ثبت کنید</legend>
                                                            <div class="control-group">
                                                                <label class="control-label input-label" for="commetnsNew">متن نظر :</label>
                                                                <div class="controls bootstrap-timepicker">
                                                                    <textarea wire:model.defer="commentText.{{$detail->id}}" id="commetnsNew" class="form-control"></textarea>
                                                                    @error("commentText.".$detail->id )
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                @endif
                                                <hr>
                                            </div>
                                        @endforeach
                                        @if($canComment)
                                            <div class="col-12">
                                                <button wire:click="storeComment()" class="btn btn-primary font-weight-bolder btn-sm">ثبت نظر</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
