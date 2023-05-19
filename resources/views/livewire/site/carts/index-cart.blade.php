<div>
    <div role="main" class="main shop py-4">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="text-dark font-weight-bold text-8">سبد خرید</h1>
                    </div>

                    <div class="col-md-12 align-self-center order-1">
                        <x-site.breadcrumbs :data="$address" />
                    </div>
                </div>
            </div>
        </section>

        <div class="container">

            <div class="row">
                <div class="col">

                    <div class="featured-boxes">
                        <div class="row">
                            <div class="col">
                                <div class="featured-box featured-box-primary text-left mt-2">
                                    <div class="box-content">
                                        <form method="post" action="">
                                            <table class="shop_table cart">
                                                <thead>
                                                <tr>
                                                    <th class="product-remove">

                                                    </th>
                                                    <th class="product-thumbnail">

                                                    </th>
                                                    <th class="product-name">
                                                        محصول
                                                    </th>
                                                    <th class="product-quantity">
                                                        تعداد
                                                    </th>
                                                    <th class="product-subtotal">
                                                        قیمت
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($cartContent as $key => $item)
                                                    <tr class="cart_table_item">
                                                        <td class="product-remove">
                                                            <a title="حذف این آیتم" wire:loading.attr="disabled"  wire:click="delete({{$key}})" class="remove" href="#">
                                                                <i class="fas fa-times align-middle"></i>
                                                            </a>
                                                        </td>
                                                        <td class="product-thumbnail">
                                                            <a>
                                                                <img width="100" height="100" alt="" class="img-fluid" src="{{asset($item->image)}}">
                                                            </a>
                                                        </td>
                                                        <td class="product-name">
                                                            <a>{{$item->title}}</a>
                                                        </td>

                                                        <td class="product-quantity">
                                                            <form enctype="multipart/form-data" method="post" class="cart">
                                                                <div class="quantity">
                                                                    <input type="button" wire:click="$set('quantities.{{$key}}',{{max(1,$quantities[$key] - 1)}})" class="minus" value="-">
                                                                    <input type="text"  wire:model="quantities.{{$key}}"  max="100" id="{{$key}}" class="input-text qty text" title="Qty" name="quantity" step="1">
                                                                    <input type="button"  wire:click="$set('quantities.{{$key}}',{{$quantities[$key] + 1}})" class="plus" value="+">
                                                                </div>
                                                            </form>
                                                        </td>
                                                        <td class="product-price">
                                                            <span class="amount"> {{number_format($item->total())}} تومان </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="featured-boxes">
                        <div class="row">
                            <div class="col-12">
                                <div class="featured-box featured-box-primary text-left mt-3 mt-lg-4">
                                    <div class="box-content">
                                        <h4 class="color-primary font-weight-semibold text-4 text-uppercase mb-3">مجموع سبد</h4>
                                        <table class="cart-totals">
                                            <tbody>
                                            <tr class="cart-subtotal">
                                                <th>
                                                    <strong class="text-dark">جمع سبد</strong>
                                                </th>
                                                <td>
                                                    <strong class="text-dark"><span class="amount">
                                                            {{number_format(App\Http\Livewire\Cart\Facades\Cart::price())}}
                                                            تومان</span></strong>
                                                </td>
                                            </tr>
                                            <tr class="shipping">
                                                <th>
                                                    تخفیف
                                                </th>
                                                <td>
                                                    {{number_format(App\Http\Livewire\Cart\Facades\Cart::discount())}}
                                                    تومان
                                                </td>
                                            </tr>
                                            <tr class="total">
                                                <th>
                                                    <strong class="text-dark d-inline-block pt-1">مجموع سفارش</strong>
                                                </th>
                                                <td>
                                                    <strong><span class="amount pt-1">{{number_format(App\Http\Livewire\Cart\Facades\Cart::total())}} <small>تومان</small></span></strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col">
                                                <div class="actions-continue mt-2">
                                                    <a href="{{ route('payment') }}" class="btn btn-primary btn-modern text-uppercase">پرداخت <i class="fas fa-angle-left ml-1"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                </div>
            </div>

        </div>
    </div>
</div>
