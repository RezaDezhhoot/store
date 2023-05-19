<div>
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="text-dark font-weight-bold text-8">ارتباط با ما</h1>
                    </div>

                    <div class="col-md-12 align-self-center order-1">
                        <x-site.breadcrumbs :data="$address" />
                    </div>
                </div>
            </div>
        </section>
        <div class="container">

            <div class="row py-4">
                <div class="col-12 col-lg-6">
                    <iframe src="{{ $data['googleMap']}}" frameborder="0" width="100%" height="400px"></iframe>
                </div>
                <div class="col-12 col-lg-6">

                    <div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="800">
                        <h4 class="mt-2 mb-1"><strong>دفتر</strong> ما</h4>
                        <ul class="list list-icons list-icons-style-2 mt-2">
                            <li class="line-height-9"><i class="fas fa-map-marker-alt top-6"></i> <strong class="text-dark">آدرس:</strong> {{$data['address']}}</li>
                            <li class="line-height-9"><i class="fas fa-phone top-6"></i> <strong class="text-dark">تلفن:</strong> <span class="ltr-text">{{$data['tel']}}</span></li>
                            <li class="line-height-9"><i class="fas fa-envelope top-6"></i> <strong class="text-dark">ایمیل:</strong> <a href="mailto:{{$data['email']}}">{{$data['email']}}</a></li>
                        </ul>
                    </div>

                    <div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="950">
                        <h4 class="pt-5"><strong>ساعات</strong> کاری</h4>
                        <ul class="list list-icons list-dark mt-2">
                            <li><i class="far fa-clock top-6"></i> شنبه تا چهارشنبه - 9 ق.ظ تا 5 ب.ظ</li>
                            <li><i class="far fa-clock top-6"></i> پنج‌شنبه - 9 ق.ظ تا 2 ب.ظ</li>
                            <li><i class="far fa-clock top-6"></i> جمعه - تعطیل</li>
                        </ul>
                    </div>

                    <h4 class="pt-5"><strong>ارتباط</strong> با ما</h4>
                    <p class="lead mb-0 text-1rem">
                        {{ $data['contactText'] }}
                    </p>

                </div>
            </div>

        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key={{$data['googleMap']}}&language=fa"></script>
</div>
