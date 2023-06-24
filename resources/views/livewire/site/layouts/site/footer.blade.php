<div>
    <!--footer area start-->
    <footer id="footer">
        <div class="container">
            <div class="footer-ribbon">
                <span>در ارتباط باشید</span>
            </div>
            <div class="row py-5 my-4">
                <div class="col-md-6 col-lg-4 mb-5 mb-lg-0">
                    <h3>{{ $data['title'] }}</h3>
                    <div class="footer_menu">
                        <ul>
                            <li><a href="{{ route('shop') }}">فروشگاه</a></li>
                            <li><a href="{{ route('articles') }}">اخبار و مقالات</a></li>
                            <li><a href="{{ route('about') }}">درباره ما</a></li>
                            <li><a href="{{ route('contact') }}">ارتباط با ما</a></li>
                            <li><a href="{{ route('faq') }}">سوالات متداول</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-5 mb-md-0">
                    <h3>راهنما</h3>
                    <div class="footer_menu">
                        <ul>
                            @foreach($data['links'] as $link)
                                <li><a href="{{ $link['link'] }}">{{ $link['title'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-5 mb-lg-0">
                    <h3> با ما در ارتباط باشید</h3>
                    <div class="footer_contact">
                        <p>{{ $data['miniAbout'] }}</p>
                        <p><span>آدرس: </span>{{ $data['address'] }}</p>
                        <p><span>تلفن: </span><a class="ltr-text" href="tel:{{$data['tel']}}">{{ $data['tel'] }}</a> </p>
                        <p><span>پشتیبانی: </span><a target="_blank" href="mailto:{{$data['email']}}">{{$data['email']}}</a></p>
                    </div>
                </div>
                <div class="col-12">
                    <h3>نماد های اعتماد</h3>
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="footer_menu">
                            <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=347267&amp;Code=RHvIHcDUueGOzxOfeHEn"><img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=347267&amp;Code=RHvIHcDUueGOzxOfeHEn" alt="" style="cursor:pointer" id="RHvIHcDUueGOzxOfeHEn"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container py-2">
                <div class="row py-4">
                    <div class="col-lg-7 d-flex align-items-center justify-content-center justify-content-lg-start mb-4 mb-lg-0">
                        <p> {{ $data['copyRight'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
