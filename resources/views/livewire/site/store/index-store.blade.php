<div>
    <div role="main" class="main shop py-4">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="text-dark font-weight-bold text-8">فروشگاه</h1>
                    </div>

                    <div class="col-md-12 align-self-center order-1">
                        <x-site.breadcrumbs :data="$address" />
                    </div>
                </div>
            </div>
        </section>
        <div class="container">

            <div class="row">
                <div class="col-lg-12">

                    <div class="masonry-loader masonry-loader-showing">
                        <div class="row products product-thumb-info-list" data-plugin-masonry data-plugin-options="{'layoutMode': 'fitRows'}">
                            @foreach($products as $product)
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
                        {!! $link !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

