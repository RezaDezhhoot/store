<div>
    <x-site.breadcrumbs :data="$address" />

    <div class="shop_area mt-60 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12" >
                    <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner">
                            <div class="widget_list widget_categories">
                                @if(!empty($single_category))
                                <h2>فیلتر ها</h2>
                                <div class="sidenav mt-4">
                                    <div class="col-12 form-group py-1 px-2 filter_groups mb-3">
                                        <button class="dropdown-btn px-2 py-2 text-black">
                                            <i class="fa fa-caret-down"></i>
                                            <strong>
                                                محدوده قیمت
                                            </strong>
                                        </button>
                                        <div class="dropdown-container mt-2" wire:ignore.self>
                                            <div class="d-flex align-items-center py-1" wire:ignore.self>
                                                <div class="price-range desk p-0" wire:ignore.self>
                                                    <span>محدوده قیمت</span>
                                                    <div class="col-12">
                                                        <input type="range"  wire:model="priceRange">
                                                    </div>
                                                    <br>
                                                    <div class="text-center d-flex align-items-center justify-content-between">
                                                        <small>از</small>
                                                        <input value="0" disabled type="text" class="p-1">
                                                        <small>تا</small>
                                                        <input value="{{number_format($range)}}" disabled class="p-1" type="text">
                                                        <small>تومان</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!empty($sub_categories))
                                        <div class="col-12 form-group py-1 px-2 filter_groups mb-3"  wire:ignore>
                                            <button class="dropdown-btn px-2 py-2 text-black">
                                                <i class="fa fa-caret-down"></i>
                                                <strong>
                                                    دسته بندی ها
                                                </strong>
                                            </button>
                                            <div class="dropdown-container mt-2">
                                                <div class="d-flex align-items-center py-1 px-4">
                                                    <input class="form-check-input" value="" name="sub_categoryd" type="radio" id="sub_categoryd" wire:model="sub_category">
                                                    <label class="mb-0 mx-2 form-check-label" for="sub_categoryd">همه</label>
                                                </div>
                                                @foreach($sub_categories as $key => $item)
                                                    <div class="d-flex align-items-center py-1 px-4">
                                                        <input class="form-check-input" value="{{$item['id']}}" name="sub_category" type="radio" id="sub_category{{$item['id']}}d" wire:model="sub_category">
                                                        <label class="mb-0 mx-2 form-check-label" for="sub_category{{$item['id']}}d">{{$item['title']}}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @foreach($groups as $key => $item)
                                        <div class="col-12 form-group py-1 px-2 filter_groups mb-3"  wire:ignore>
                                            <button class="dropdown-btn px-2 py-2 text-black">
                                                <i class="fa fa-caret-down"></i>
                                                <strong>
                                                    {{ $item['title']}}
                                                </strong>
                                            </button>
                                            <div class="dropdown-container mt-2">
                                                @foreach($item['filters'] as $key => $filter)
                                                    <div class="d-flex align-items-center py-1 px-4">
                                                        <input type="checkbox" class="big-checkbox form-check-input" id="fliter{{$filter['id']}}d" wire:model="filter.{{$filter['id']}}">
                                                        <label class="mb-0 mx-2 form-check-label" for="fliter{{$filter['id']}}d">{{$filter['title']}}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @else
                                    <h2>دسته بندی ها</h2>
                                    <ul>
                                        @foreach($categories as $item)
                                            <li><a href="{{ route('shop',$item->slug) }}">{{ $item->title }}</a></li>
                                        @endforeach
                                    </ul>
                                    <div class="sidenav mt-4">
                                        <div class="col-12 form-group py-1 px-2 filter_groups mb-3">
                                            <button class="dropdown-btn px-2 py-2 text-black">
                                                <i class="fa fa-caret-down"></i>
                                                <strong>
                                                    محدوده قیمت
                                                </strong>
                                            </button>
                                            <div class="dropdown-container mt-2" wire:ignore.self>
                                                <div class="d-flex align-items-center py-1" wire:ignore.self>
                                                    <div class="price-range desk p-0" wire:ignore.self>
                                                        <span>محدوده قیمت</span>
                                                        <div class="col-12">
                                                            <input type="range"  wire:model="priceRange">
                                                        </div>
                                                        <br>
                                                        <div class="text-center d-flex align-items-center justify-content-between">
                                                            <small>از</small>
                                                            <input value="0" disabled type="text" class="p-1">
                                                            <small>تا</small>
                                                            <input value="{{number_format($range)}}" disabled class="p-1" type="text">
                                                            <small>تومان</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </aside>
                    <!--sidebar widget end-->
                </div>
                <div class="col-lg-9 col-md-12">
                    <!--shop wrapper start-->
                    <!--shop toolbar start-->
                    <div class="shop_toolbar_wrapper">
                        <div class="niceselect_container col-6">
                            <form>
                                <label for="short">ترتیب:</label>
                                <select wire:model="most_amount" class="select_option form-control" name="orderby" id="short">
                                    <option value="desc">قیمت صعودی</option>
                                    <option value="asc">قیمت نزولی</option>
                                </select>
                            </form>
                        </div>
                        <div class="shop_toolbar_btn">

                            <button data-role="grid_3" type="button" class="active btn-grid-3" data-toggle="tooltip" title="3"></button>

                            <button data-role="grid_4" type="button" class=" btn-grid-4" data-toggle="tooltip" title="4"></button>

                            <button data-role="grid_list" type="button" class="btn-list" data-toggle="tooltip" title="لیست"></button>
                        </div>

                    </div>
                    <!--shop toolbar end-->

                    <div class="row shop_wrapper">
                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <article class="single_product">
                                    <figure>
                                        <div class="product_thumb">
                                            <a class="primary_img" href="{{ route('product',$product->slug) }}"><img src="{{ asset($product->image) }}" alt="{{ $product->title }}"></a>
                                            <a class="secondary_img" href="{{ route('product',$product->slug) }}"><img src="{{ asset($product->image) }}" alt="{{ $product->title }}"></a>
                                            <div class="action_links">
                                                <ul>
                                                    <li class="wishlist" wire:click="addToWishlist('{{$product->id}}')">
                                                        <a title="افزودن به علاقه‌مندی‌ها">
                                                            <i class="fa fa-heart-o text-white" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product_content grid_content">
                                            <div class="price_box">
                                                @if(empty($product->form))
                                                    @if($product->hasReduction())
                                                        <span class="old_price">{{ number_format($product->price) }} تومان </span>
                                                        <span class="current_price">
                                                                {{ number_format($product->price()) }}تومان
                                                            </span>
                                                    @else
                                                        <span class="current_price">
                                                                {{ number_format($product->price) }}تومان
                                                            </span>
                                                    @endif
                                                @else
                                                    <span class="current_price">
                                                               قیمت متغیر
                                                        </span>
                                                @endif
                                            </div>
                                            <div class="product_ratings">
                                                <ul>
                                                    @for($i = 0;$i<floor($product['score']);$i++)
                                                        <li><a><i class="ion-android-star-outline"></i></a></li>
                                                    @endfor
                                                </ul>
                                            </div>
                                            <h3 class="product_name grid_name"><a href="{{ route('product',$product->slug) }}">{{ $product->title }}</a></h3>
                                        </div>
                                        <div class="product_content list_content">
                                            <div class="left_caption">
                                                <div class="price_box">
                                                    @if(empty($product->form))
                                                        @if($product->hasReduction())
                                                            <span class="old_price">{{ number_format($product->price) }} تومان </span>
                                                            <span class="current_price">
                                                                {{ number_format($product->price()) }}تومان
                                                            </span>
                                                        @else
                                                            <span class="current_price">
                                                                {{ number_format($product->price) }}تومان
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="current_price">
                                                               قیمت متغیر
                                                        </span>
                                                    @endif
                                                </div>
                                                <h3 class="product_name"><a href="{{ route('product',$product->slug) }}">{{ $product->title }}</a></h3>
                                                <div class="product_ratings">
                                                    <ul>
                                                        @for($i = 0;$i<floor($product['score']);$i++)
                                                            <li><a><i class="ion-android-star-outline"></i></a></li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                                <div class="product_desc">
                                                    {!! $product->short_description !!}
                                                </div>
                                            </div>
                                            <div class="right_caption">
                                                <div class="action_links">
                                                    <ul>
                                                        <li  wire:click="addToWishlist('{{$product->id}}')" class="wishlist"><a title="افزودن به علاقه‌مندی‌ها"><i class="fa fa-heart-o text-white" aria-hidden="true"></i>  افزودن به علاقه‌مندی‌ها</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </figure>
                                </article>
                            </div>
                        @endforeach
                    </div>
                    <div>
                        {!! $link !!}
                    </div>
                    <!--shop toolbar end-->
                    <!--shop wrapper end-->
                </div>
            </div>
        </div>
    </div>

</div>

