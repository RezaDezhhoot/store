<div>

    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="text-dark font-weight-bold text-8">درباره ما</h1>
                    </div>

                    <div class="col-md-12 align-self-center order-1">
                        <x-site.breadcrumbs :data="$address" />
                    </div>
                </div>
            </div>
        </section>
        <div class="container pb-1">
            <section class="section bg-white section-default border-0 my-5 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="750">
                <div class="container py-4">

                    <div class="row align-items-center">
                        <div class="col-md-6 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="1000">
                            <div class="owl-carousel owl-theme nav-inside mb-0" data-plugin-options="{'items': 1, 'margin': 10, 'animateOut': 'fadeOut', 'autoplay': true, 'autoplayTimeout': 6000, 'loop': true}">
                                @foreach(explode(',',$data['aboutUsImages']) as $item)
                                    <div>
                                        <img alt="" class="img-fluid" src="{{ asset($item) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="overflow-hidden mb-2">
                                <h2 class="text-color-dark font-weight-normal text-5 mb-0 pt-0 mt-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="1200"><strong class="font-weight-extra-bold">معرفی</strong> ما</h2>
                            </div>
                            {!! $data['aboutUs'] !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mx-md-auto text-center">

                            <h2 class="text-color-dark font-weight-normal text-5 mb-2 pt-2"><strong class="font-weight-extra-bold">تاریخچه</strong> ما</h2>
                            <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.</p>

                            <div class="py-4 py-md-3"></div>

                            <section class="timeline mb-n5" id="timeline">
                                <div class="timeline-body">
                                    <div class="timeline-date">
                                        <h3 class="text-primary font-weight-bold">2020</h3>
                                    </div>

                                    <article class="timeline-box left text-left appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="200">
                                        <div class="timeline-box-arrow"></div>
                                        <div class="p-2">
                                            <img alt="" class="img-fluid" src="{{asset('assets/img/history/history-3.jpg')}}">
                                            <h3 class="font-weight-bold text-3 mt-3 mb-1">دفتر جدید</h3>
                                            <p class="mb-0 text-2">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه</p>
                                        </div>
                                    </article>

                                    <div class="timeline-date">
                                        <h3 class="text-primary font-weight-bold">2012</h3>
                                    </div>

                                    <article class="timeline-box right text-left appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="400">
                                        <div class="timeline-box-arrow"></div>
                                        <div class="p-2">
                                            <img alt="" class="img-fluid" src="{{asset('assets/img/history/history-3.jpg')}}">
                                            <h3 class="font-weight-bold text-3 mt-3 mb-1">شرکای جدید</h3>
                                            <p class="mb-0 text-2">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون</p>
                                        </div>
                                    </article>

                                    <div class="timeline-date">
                                        <h3 class="text-primary font-weight-bold">2006</h3>
                                    </div>

                                    <article class="timeline-box left text-left appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="600">
                                        <div class="timeline-box-arrow"></div>
                                        <div class="p-2">
                                            <img alt="" class="img-fluid" src="{{asset('assets/img/history/history-3.jpg')}}">
                                            <h3 class="font-weight-bold text-3 mt-3 mb-1">تاسیس</h3>
                                            <p class="mb-0 text-2">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها</p>
                                        </div>
                                    </article>
                                </div>
                            </section>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
