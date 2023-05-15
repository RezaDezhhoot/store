<div>
    <x-site.breadcrumbs :data="$address" />



    <div class="Checkout_section mt-60">
        <div class="container">
            <div class="row">
                <div class="col-12" >
                    <div class="user-actions" >
                        <h3>
                            <i class="fa fa-file-o" aria-hidden="true"></i>
                            کد تخفیف دارید؟
                            <a class="Returning" href="#" data-toggle="collapse" data-target="#checkout_coupon" aria-expanded="true">برای وارد کردن کد تخفیف کلیک کنید</a>

                        </h3>
                        <div id="checkout_coupon" class="collapse" wire:ignore.self>
                            <div class="checkout_info">
                                <form wire:submit.prevent="checkVoucherCode">
                                    <input placeholder="کد تخفیف" wire:model.defer="voucherCode" type="text">
                                    <button type="submit">اعمال کد تخفیف</button>
                                </form>
                                @error('voucher')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout_form">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <form action="#">
                            <h3>جزئیات پرداخت</h3>
                            <div class="row">

                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="name">نام کامل<span>*</span></label>
                                        <input id="name" wire:model.defer="name" class="form-control" placeholder="نام و نام خانوادگی" type="text">
                                        @error('name')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="phone">شماره موبایل<span>*</span></label>
                                        <input id="phone" wire:model.defer="phone" class="form-control" placeholder="شماره موبایل" type="text">
                                        @error('phone')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 mb-20">
                                   <div class="form-group">
                                       <label for="province">استان <span>*</span></label>
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
                                <div class="col-6 mb-20">
                                    <div class="form-group">
                                        <label for="city">شهر <span>*</span></label>
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
                                <div class="col-12 mb-20">
                                    <div class="form-group">
                                        <label for="fullAddress">ادرس کامل</label>
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
                                        <label for="postal_code">کد پستی<span>*</span></label>
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
                                        <label for="description">توضیحات سفارش</label>
                                        <textarea class="form-control" wire:model.defer="description" id="description" placeholder="یادداشت های مربوط به سفارش، مانند توضیح نحوه ارسال."></textarea>
                                        @error('description')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <form wire:submit.prevent="payment">
                            <h3>سفارش شما</h3>
                            <div class="order_table table-responsive">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>محصول</th>
                                        <th>جمع</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cartContent as $key => $item)
                                        <tr>
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
                                        <th>کیف پول</th>
                                        <td><strong>{{ number_format($walletAmount) }} تومان </strong></td>
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
                                    <tr class="order_total">
                                        <th>مجموع سفارش</th>
                                        <td>{{number_format(App\Http\Livewire\Cart\Facades\Cart::total($walletAmount,$voucherAmount,$sendAmount))}} تومان </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="payment_method" id="accordion">
                                <div class="form-group">
                                    <label>
                                        <input wire:model="useWallet" name="check_method" type="checkbox">استفاده از کیف پول
                                    </label>
                                    @error('payment')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div wire:ignore>
                                    @foreach($sends as $key => $item)
                                        <div class="panel-default">
                                            <label data-toggle="collapse" data-target="#collapsedefult{{$item->id}}" aria-controls="collapsedefult{{$item->id}}">
                                                <input value="{{$item->id}}" type="radio" wire:model="selectedSend"> {{ $item->slug }}
                                                <img class="send-icon" src="{{ asset($item->logo) }}" alt="">
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
                                <div class="order_button">
                                    <button wire:loading.attr="disabled" type="submit">ادامه پرداخت</button>
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
            </div>
        </div>
    </div>
</div>
