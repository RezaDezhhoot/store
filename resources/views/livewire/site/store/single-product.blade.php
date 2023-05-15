<div xmlns:wire="http://www.w3.org/1999/xhtml" wire:init="$set('readyToLoad', true)">
    <x-site.breadcrumbs :data="$address" />

    <!--product details start-->
    <div class="product_details mt-60 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6" wire:ignore>
                    <div class="product-details-tab">
                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                <img id="zoom1" src="{{ asset($product->image) }}" data-zoom-image="{{ asset($product->image) }}" alt="{{ $product->title }}">
                            </a>
                        </div>
                        <div class="single-zoom-thumb">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                @foreach(explode(',',$product->media) as $item)
                                    <li>
                                        <a class="elevatezoom-gallery active" data-update="{{asset($item)}}" data-image="{{asset($item)}}" data-zoom-image="{{asset($item)}}">
                                            <img src="{{asset($item)}}" alt="{{ $product->title }}">
                                        </a>

                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">
                        <form wire:submit.prevent="addToCart()">

                            <h1>{{ $product->title }}</h1>

                            <div class=" product_ratting">
                                <ul>
                                    @for($i = 0;$i<floor($product->score);$i++)
                                        <li><span><i class="fa fa-star"></i></span></li>
                                    @endfor
                                    <li class="review"><a> (امتیاز مشتریان) </a></li>
                                </ul>
                            </div>
                            <div class="price_box">
                                @if($product->hasReduction())
                                    <span class="current_price">
                                            {{ number_format($price) }}تومان
                                        </span>
                                    <span class="old_price">{{ number_format($priceWithDiscount) }} تومان </span>

                                @else
                                    <span class="current_price">
                                            {{ number_format($price) }}تومان
                                        </span>
                                @endif

                            </div>
                            <div class="product_desc">
                                <p>
                                    {!! $product->short_description !!}
                                </p>
                            </div>
                            <div class="product_variant color">
                                @include('livewire.site.components.products.form-builder')
                            </div>
                            <div class="product_variant quantity">
                                <label for="quantity">تعداد</label>
                                <input id="quantity" min="1" wire:model="quantity" max="100" value="1" type="number">
                                @error('quantity')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                                <button class="button" wire:loading.attr="disabled" type="submit">افزودن به سبد</button>
                            </div>
                            <div class="product_meta">
                                @if(!is_null($product->category) && !empty($product->category))
                                    <span>دسته: <a href="{{ route('shop',$product->category->slug) }}">{{ $product->category->title }}</a></span>
                                @endif
                            </div>

                        </form>
                        <div class="priduct_social">
                            <ul>
                                <li><a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" title="facebook"><i class="fa fa-facebook"></i>فیسبوک</a></li>
                                <li><a class="twitter" href="https://twitter.com/intent/tweet?url={{ url()->current() }}" title="twitter"><i class="fa fa-twitter"></i>توییتر</a></li>
                                <li><a class="telegram" href="https://t.me/share/url?url={{ url()->current() }}" title="telegram"><i class="fa fa-telegram"></i>تلگرام</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product details end-->

    <!--product info start-->
    <div class="product_d_info mb-60" wire:ignore>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_d_inner">
                        <div class="product_info_button">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">توضیحات</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">مشخصات فنی</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false"> نطرات {{ $comments->count() == 0 ? '' : $comments->count() }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <div class="product_info_content">
                                    {!!  $product->description !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sheet" role="tabpanel">
                                <div class="product_d_table">
                                    {!!  $product->details !!}
                                </div>
                            </div>

                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                <div class="reviews_wrapper">
                                    @foreach($comments as $item)
                                        <div class="reviews_comment_box">
                                            <div class="comment_thmb">
                                                <img src="{{asset('assets/img/blog/comment2.jpg')}}" alt="">
                                            </div>
                                            <div class="comment_text">
                                                <div class="reviews_meta">
                                                    <div class="star_rating">
                                                        <ul>
                                                            @for($i = 0;$i<floor($item->rating);$i++)
                                                                <li><span><i class="ion-ios-star"></i></span></li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                    <p><strong>{{ $item->user->user_name }} </strong> - {{ $item->date }}</p>
                                                </div>
                                                <p>
                                                    {!! $item->comment !!}
                                                </p>
                                                @if(!is_null($item->answer))
                                                    <div class="comment_list list_two">
                                                        <div class="comment_thumb">
                                                            <img src="{{asset('assets/img/blog/comment3.png.jpg')}}" alt="">
                                                        </div>
                                                        <div class="comment_content">
                                                            <div class="comment_meta">
                                                                <h5><a>پشتیبانی</a></h5>
                                                                <span>{{ $item->updateDate }}</span>
                                                            </div>
                                                            <p>
                                                                {!! $item->answer !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product info end-->

    <section class="product_area related_products" wire:ignore>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <h2>محصولات مرتبط	</h2>
                    </div>
                </div>
            </div>
            <div class="product_carousel product_column5 owl-carousel">
                @foreach($related as $item)
                    <article class="single_product">
                        <figure>
                            <div class="product_thumb">
                                <a class="primary_img" href="{{ route('product',$item->slug) }}"><img src="{{ asset($item->image) }}" alt="{{ $item->title }}"></a>
                                <a class="secondary_img" href="{{ route('product',$item->slug) }}"><img src="{{ asset($item->image) }}" alt="{{ $item->title }}"></a>
                            </div>
                            <figcaption class="product_content">
                                <div class="price_box">
                                    @if(empty($item->form))
                                        @if($item->hasReduction())
                                            <span class="current_price">
                                            {{ number_format($product->price()) }}تومان
                                        </span>
                                            <span class="old_price">{{ number_format($item->price) }} تومان </span>
                                        @else
                                            <span class="current_price">
                                            {{ number_format($item->price) }}تومان
                                        </span>
                                        @endif
                                    @else
                                        <span class="current_price">
                                        قیمت متغیر
                                    </span>
                                    @endif
                                </div>
                                <h3 class="product_name"><a href="{{ route('product',$item->slug) }}">{{ $item->title }}</a></h3>
                            </figcaption>
                        </figure>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</div>
