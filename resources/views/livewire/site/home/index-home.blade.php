<div >
        <div role="main" class="main">
            <livewire:site.layouts.site.slider />

            <div class="container">
                <div class="row align-items-center mb-5">
                    <div class="col-lg-7 pr-5 appear-animation" data-appear-animation="fadeInRightShorter">
                        {!! $about !!}
                    </div>
                    <div class="col-lg-5">
                        <div class="row mt-5 mt-lg-0">
                            <div class=" col-12 text-center text-lg-left mx-auto">
                                <img class="img-fluid m-3 my-0  appear-animation" src="{{$data['img1']}}" alt="تصاویر شرکت" data-appear-animation="expandIn" data-appear-animation-delay="200">
                            </div>
{{--                            <div class="col-md-8 col-lg-6 pl-lg-0 text-center text-lg-left mx-auto">--}}
{{--                                <img class="img-fluid m-3 my-0 appear-animation" alt="تصاویر شرکت" src="{{$data['img2']}}"  data-appear-animation="expandIn" data-appear-animation-delay="400">--}}
{{--                                <img class="img-fluid m-3 my-0 appear-animation" src="{{$data['img3']}}" alt="تصاویر شرکت" data-appear-animation="expandIn" data-appear-animation-delay="200">--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row pt-4 mt-5">
                    <div class="col-lg-12 text-center appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="400">
                        <h2 class="font-weight-normal text-6 mb-5"><strong class="font-weight-extra-bold">محصولات </strong> ما</h2>
                    </div>
                </div>
                <div role="main" class="main shop py-4">

                    <div class="container">

                        <div class="masonry-loader masonry-loader-showing">
                            <div class="row products product-thumb-info-list" data-plugin-masonry data-plugin-options="{'layoutMode': 'fitRows'}">
                                @foreach($products as $product)
                                <div class="col-12 col-sm-6 col-lg-3 product">
                                    <span class="product-thumb-info border-0">
									<a href="{{ route('product',$product->slug) }}" class="add-to-cart-product bg-color-primary">
										<span class="text-1">افزودن به سبد</span>
									</a>
									<a href="{{ route('product',$product->slug) }}">
										<span class="product-thumb-info-image">
											<img alt="{{$product->title}}" class="img-fluid" src="{{asset($product->image)}}">
										</span>
									</a>
									<span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
										<a href="{{ route('product',$product->slug) }}">
											<h4 class="text-4 text-primary">{{$product->title}}</h4>
											<span class="price">
                                                @if($product->hasReduction())
                                                    <del><span class="amount">{{ number_format($product->price) }} تومان</span></del>
                                                    <ins><span class="amount text-dark font-weight-semibold">{{ number_format($product->price()) }} تومان</span></ins>
                                                @else
                                                    <ins><span class="amount text-dark font-weight-semibold">{{ number_format($product->price) }} تومان</span></ins>

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
            <div class="container">
                <div class="row mt-4">
                    <div class="col-lg-12 text-center appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
                        <h2 class="font-weight-normal text-6 mt-3 mb-5">آخرین <strong class="font-weight-extra-bold">مطالب</strong></h2>
                    </div>
                </div>
                <div class="row recent-posts pb-4 mb-5 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200">
                    @foreach($articles as $article)
                        <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
                            <article>
                                <div class="row">
                                    <div class="col-auto pr-0">
                                        <div class="date">
                                            <span class="day text-color-dark font-weight-extra-bold">{{$article['day']}}</span>
                                            <span class="month top-1 bg-color-primary font-weight-semibold text-color-light text-1">{{$article['month']}}</span>
                                        </div>
                                    </div>
                                    <div class="col pl-1">
                                        <h4 class="line-height-8 text-4 primary-font mt-n1"><a href="{{route('article',[$article['slug']])}}" class="text-dark">{{ $article['title'] }}</a></h4>
                                        <p class="pr-3 mb-1">{{$article['sub_title']}}</p>
                                        <a class="btn btn-light text-primary text-1 py-2 px-3 mb-1 mt-2" href="{{route('article',[$article['slug']])}}"><strong>مشاهده بیشتر</strong><i class="fas fa-chevron-left text-2 pl-2"></i></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
</div>
