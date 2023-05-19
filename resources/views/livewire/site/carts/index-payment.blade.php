<div>
    <div role="main" class="main shop">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="text-dark font-weight-bold text-8">تکمیل خرید</h1>
                    </div>

                    <div class="col-md-12 align-self-center order-1">
                        <x-site.breadcrumbs :data="$address" />
                    </div>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                        <div class="accordion accordion-modern" id="accordion">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h4 class="card-title m-0">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#off">برای وارد کردن کد تخفیف کلیک کنید</a>
                                    </h4>
                                </div>
                                <div id="off" wire:ignore.self class="collapse">
                                    <div class="card-body">
                                        <form wire:submit.prevent="checkVoucherCode">
                                            <input class="form-control" placeholder="کد تخفیف" wire:model.defer="voucherCode" type="text">
                                            <button class="btn btn-sm mt-2 btn-outline-primary" type="submit">اعمال کد تخفیف</button>
                                        </form>
                                        @error('voucher')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <form wire:submit.prevent="payment">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h4 class="card-title m-0">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                            جزئیات پرداخت
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-dark text-2" for="name">نام کامل<span>*</span></label>
                                                    <input id="name" wire:model.defer="name" class="form-control" placeholder="نام و نام خانوادگی" type="text">
                                                    @error('name')
                                                    <span class="text-danger">
                                                        {{$message}}
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-dark text-2" for="phone">شماره موبایل<span>*</span></label>
                                                    <input id="phone" wire:model.defer="phone" class="form-control" placeholder="شماره موبایل" type="text">
                                                    @error('phone')
                                                    <span class="text-danger">
                                                {{$message}}
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-dark text-2" for="province">استان <span>*</span></label>
                                                    <select wire:model="province" class="form-control" name="province" id="province">
                                                        <option value="">انتخاب</option>
                                                        @foreach($data['province'] as $key => $item)
                                                            <option value="{{$key}}">{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('province')
                                                    <span class="text-danger">
                                                {{$message}}
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-dark text-2" for="city">شهر <span>*</span></label>
                                                    <select wire:model="city" class="form-control" name="city" id="city">
                                                        <option value="">انتخاب</option>
                                                        @foreach($data['city'] as $key => $item)
                                                            <option value="{{$key}}">{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('city')
                                                    <span class="text-danger">
                                                {{$message}}
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-dark text-2" for="fullAddress">ادرس کامل</label>
                                                    <textarea id="fullAddress" wire:model.defer="fullAddress" class="form-control" placeholder="خیابان/محله/کوچه/پلاک"></textarea>
                                                    @error('fullAddress')
                                                    <span class="text-danger">
                                                {{$message}}
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 mb-20">
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-dark text-2" for="postal_code">کد پستی<span>*</span></label>
                                                    <input id="postal_code" wire:model.defer="postal_code" class="form-control" placeholder="نام و نام خانوادگی" type="text">
                                                    @error('postal_code')
                                                    <span class="text-danger">
                                                {{$message}}
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold text-dark text-2" for="description">توضیحات سفارش</label>
                                                    <textarea class="form-control" wire:model.defer="description" id="description" placeholder="یادداشت های مربوط به سفارش، مانند توضیح نحوه ارسال."></textarea>
                                                    @error('description')
                                                    <span class="text-danger">
                                                {{$message}}
                                            </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h4 class="card-title m-0">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#send">روش ارسال</a>
                                        </h4>
                                    </div>
                                    <div id="send" wire:ignore.self class="collapse show">
                                        <div class="card-body">
                                            <div wire:ignore class="d-flex">
                                                @foreach($sends as $key => $item)
                                                    <div class="panel-default mx-2">
                                                        <label class="d-flex align-items-center" data-toggle="collapse" data-target="#collapsedefult{{$item->id}}" aria-controls="collapsedefult{{$item->id}}">
                                                            <input value="{{$item->id}}" type="radio" wire:model="selectedSend"> {{ $item->slug }}
                                                            <img style="width: 40px" src="{{ asset($item->logo) }}" alt="">
                                                        </label>

                                                        <div id="collapsedefult{{$item->id}}" class="collapse one" data-parent="#accordion">
                                                            <div class="card-body1">
                                                                {!! $item->note !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('selectedSend')
                                            <span class="text-danger">
                                        {{$message}}
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            <div class="actions-continue mt-2">
                                <div>
                                    <input type="submit" value="ثبت سفارش" name="proceed" class="btn btn-primary btn-modern text-uppercase mt-4 mb-5 mb-lg-0">
                                </div>
                                <div wire:loading>
                                    <p class="text-secondary">
                                        در حال پردازش ...
                                    </p>
                                </div>
                            </div>
                            </form>
                        </div>
                </div>
                <div class="col-lg-3 mt-3 mt-lg-0 mb-n3">
                    <h4 class="text-primary">سفارش شما </h4>
                    <table class="cart-totals">
                        <thead>
                        <tr>
                            <th>محصول</th>
                            <th>جمع</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cartContent as $key => $item)
                            <tr class="cart-subtotal">
                                <td><span>{{$item->title}}</span> <strong>× {{ $item->quantity }}</strong></td>
                                <td>{{number_format($item->total())}} تومان </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>جمع سبد</th>
                            <td>{{number_format(App\Http\Livewire\Cart\Facades\Cart::total())}} تومان </td>
                        </tr>
                        <tr>
                            <th>کد تخفیف</th>
                            <td><strong>{{ number_format($voucherAmount) }} تومان </strong></td>
                        </tr>
                        <tr>
                            <th>حمل و نقل</th>
                            <td>
                                <strong>
                                    @if($sendAmount > 0 && isset($selectedSend))
                                        {{ number_format($sendAmount) }} تومان
                                    @elseif($sendAmount == 0 && isset($selectedSend))
                                        رایگان
                                    @else
                                        انتخاب نشده
                                    @endif
                                </strong>
                            </td>
                        </tr>
                        <tr class="total">
                            <th>  <strong class="text-dark d-inline-block pt-1">مجموع سفارش</strong> </th>
                            <td class="total">
                                <strong><span class="amount pt-1"><span class="text-1">
                                {{number_format(App\Http\Livewire\Cart\Facades\Cart::total($walletAmount,$voucherAmount,$sendAmount))}}
                                            </span>
                                 <small>تومان</small></span></strong>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>
