<div>
    <x-site.breadcrumbs :data="$address" />



    <div class="shopping_cart_area mt-60">
        <div class="container">
            <form>
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            <div class="cart_page table-responsive">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="product_remove">حذف</th>
                                        <th class="product_thumb">تصویر</th>
                                        <th class="product_name">محصول</th>
                                        <th class="product_quantity">تعداد</th>
                                        <th class="product_total">جمع کل</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($cartContent as $key => $item)
                                        <tr>
                                            <td class="product_remove">
                                                <a wire:loading.attr="disabled" wire:click="delete({{$key}})">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                            <td class="product_thumb">
                                                <a href="#"><img src="{{asset($item->image)}}" alt=""></a>
                                            </td>
                                            <td class="product_name">
                                                <a>{{$item->title}}</a>
                                                <ul class="text-sm whitespace-nowrap">
                                                    @foreach($item->form as $form)
                                                        @if(($form['type'] ?? '') != 'paragraph')
                                                            <span>{!! $form['label'] ?? '' !!}</span>
                                                            <p class="font-medium">{{$form['value'] ?? ''}}</p>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="product_quantity">
                                                <label>تعداد</label>
                                                <input wire:model="quantities.{{$key}}" min="1" max="100" value="1" type="number">
                                            </td>
                                            <td class="product_total">{{number_format($item->total())}} تومان </td>


                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area start-->
                <div class="coupon_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="coupon_code right">
                                <h3>مجموع سبد</h3>
                                <div class="coupon_inner">
                                    <div class="cart_subtotal">
                                        <p>جمع اجزا</p>
                                        <p class="cart_amount">
                                            {{number_format(App\Http\Livewire\Cart\Facades\Cart::price())}}
                                            تومان
                                        </p>
                                    </div>
                                    <div class="cart_subtotal ">
                                        <p>تخقیف</p>
                                        <p class="cart_amount">
                                            {{number_format(App\Http\Livewire\Cart\Facades\Cart::discount())}} تومان
                                        </p>
                                    </div>



                                    <div class="cart_subtotal has-border">
                                        <p>جمع کل</p>
                                        <p class="cart_amount">{{number_format(App\Http\Livewire\Cart\Facades\Cart::total())}} تومان </p>
                                    </div>
                                    <div class="checkout_btn">
                                        <a href="{{ route('payment') }}">پرداخت</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area end-->
            </form>
        </div>
    </div>
</div>
