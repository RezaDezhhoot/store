<div xmlns:wire="http://www.w3.org/1999/xhtml" wire:init="$set('readyToLoad', true)">

    <div role="main" class="main shop">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="text-dark font-weight-bold text-8">{{ $product->title }}</h1>
                    </div>

                    <div class="col-md-12 align-self-center order-1">
                        <x-site.breadcrumbs :data="$address" />
                    </div>
                </div>
            </div>
        </section>
        <div class="container">

            <div class="row">
                <div class="col-lg-6">

                    <div class="owl-carousel owl-theme" wire:ignore data-plugin-options="{'items': 1}">
                        <div>
                            <img alt="{{ $product->title }}" class="img-fluid" src="{{ asset($product->image) }}">
                        </div>
                        @foreach(explode(',',$product->media) as $item)
                            <div>
                                <img alt="{{ $product->title }}" class="img-fluid" src="{{asset($item)}}">
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="summary entry-summary">

                        <h1 class="mb-2 font-weight-bold text-7">{{$product->title}}</h1>

                        <p class="price">
                            @if($product->hasReduction())
                                <del>
                                            <span  class="amount">
                                                {{ number_format($price) }}تومان
                                            </span>
                                        </del>
                                <ins>
                                    <span class="amount">{{ number_format($priceWithDiscount) }} تومان </span>
                                </ins>
                            @else
                                <span class="amount">
                                            {{ number_format($price) }}تومان
                                        </span>
                            @endif
                        </p>

                        <p class="mb-4">
                            {!! $product->short_description !!}
                        </p>

                        <form wire:submit.prevent="addToCart()" class="cart">
                            <div class="quantity quantity-lg">
                                <input type="button" wire:click="$set('quantity',{{max(1,$quantity - 1)}})" class="minus" value="-">
                                <input type="text" wire:model="quantity" class="input-text qty text" title="Qty" value="1" name="quantity" min="1" step="1">
                                <input type="button" wire:click="$set('quantity',{{$quantity + 1}})" class="plus" value="+">
                            </div>
                            @error('quantity')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                            <button wire:loading.attr="disabled" type="submit" class="btn btn-primary btn-modern text-uppercase">افزودن به سبد</button>
                        </form>

                        <div class="product-meta">
                            @if(!is_null($product->category) && !empty($product->category))
                                <span class="posted-in">دسته: <a rel="tag" href="{{ route('shop',$product->category->slug) }}">{{ $product->category->title }}</a></span>
                            @endif
                        </div>

                    </div>


                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="tabs tabs-product mb-2">
                        <ul class="nav nav-tabs d-block d-sm-flex">
                            <li class="nav-item active"><a class="nav-link py-3 px-4" href="#productDescription" data-toggle="tab">توضیحات</a></li>
                            <li class="nav-item"><a class="nav-link py-3 px-4" href="#productInfo" data-toggle="tab">اطلاعات تکمیلی</a></li>
                            <li class="nav-item"><a class="nav-link py-3 px-4" href="#productReviews" data-toggle="tab"> نظرات {{ $comments->count() == 0 ? '' : $comments->count() }}</a></li>
                        </ul>
                        <div class="tab-content p-0">
                            <div class="tab-pane p-4 active" id="productDescription">
                                {!! $product->description !!}
                            </div>
                            <div class="tab-pane p-4" id="productInfo">
                                {!! $product->details !!}
                            </div>
                            <div class="tab-pane p-4" id="productReviews">
                                <ul class="comments">
                                    @forelse($comments as $item)
                                        <li>
                                            <div class="comment">
                                                <div class="img-thumbnail img-thumbnail-no-borders d-none d-sm-block">
                                                    <i class="fa fa-4x fa-user"></i>
                                                </div>
                                                <div class="comment-block">
                                                    <div class="comment-arrow"></div>
                                                    <span class="comment-by">
																<strong>{{ $item->user->user_name }}</strong>
															</span>
                                                    {!! $item->comment !!}
                                                    <span class="date float-right">{{ $item->date }}</span>
                                                </div>
                                            </div>
                                            @if(!is_null($item->answer))
                                                <ul class="comments reply">
                                                    <li>
                                                        <div class="comment">
                                                            <div class="img-thumbnail img-thumbnail-no-borders d-none d-sm-block">
                                                                <i class="fa fa-4x fa-user"></i>
                                                            </div>
                                                            <div class="comment-block">
                                                                <div class="comment-arrow"></div>
                                                                <span class="comment-by">
																		<strong>پشتیبانی </strong>
																	</span>
                                                                <p>
                                                                    {!! $item->answer !!}
                                                                </p>
                                                                <span class="date float-right">{{ $item->updateDate }}</span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            @endif
                                        </li>
                                    @empty
                                        <p class="alert alert-info">هیچ نظری ثبت نشده است</p>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <hr class="solid my-5">

                    <h4 class="mb-4"><strong>محصولات</strong> مرتبط</h4>
                    <div class="masonry-loader masonry-loader-showing">
                        <div class="row products product-thumb-info-list mt-3" data-plugin-masonry data-plugin-options="{'layoutMode': 'fitRows'}">
                            @foreach($related as $item)
                                <div class="col-sm-6 col-lg-4 product">
                                    <span class="product-thumb-info border-0">
											<a href="{{ route('product',$product->slug) }}" class="add-to-cart-product bg-color-primary">
												<span class="text-1">افزودن به سبد</span>
											</a>
											<a href="{{ route('product',$product->slug) }}">
												<span class="product-thumb-info-image">
													<img alt="{{ $product->title }}" class="img-fluid" src="{{ asset($product->image) }}">
												</span>
											</a>
											<span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
												<a href="{{ route('product',$product->slug) }}">
													<h4 class="text-4 text-primary">{{ $product->title }}</h4>
													<span class="price">
                                                        @if($product->hasReduction())
                                                            <del><span class="amount">{{ number_format($product->price()) }} تومان</span></del>
                                                            <ins><span class="amount text-dark font-weight-semibold">{{ number_format($product->price) }} تومان</span></ins>
                                                        @else
                                                            <span class="amount text-dark font-weight-semibold">{{ number_format($product->price()) }} تومان</span>
                                                        @endif
													</span>
												</a>
											</span>
										</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
