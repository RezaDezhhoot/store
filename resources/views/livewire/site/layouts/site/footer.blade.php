<div>
    <!--footer area start-->
    <footer class="footer_widgets">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="widgets_container contact_us">
                            <div class="footer_logo">
                                <a href="{{ route('home') }}"><img src="{{ asset($data['logo']) }}" alt=""></a>
                            </div>
                            <div class="footer_contact">
                                <p>{{ $data['miniAbout'] }}</p>
                                <p><span>آدرس: </span>{{ $data['address'] }}</p>
                                <p><span>تلفن: </span><a class="ltr-text" href="tel:{{$data['tel']}}">{{ $data['tel'] }}</a> </p>
                                <p><span>پشتیبانی: </span><a target="_blank" href="mailto:{{$data['email']}}">{{$data['email']}}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="widgets_container widget_menu">
                            <h3>برگه ها</h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="{{ route('shop') }}">فروشگاه</a></li>
                                    <li><a href="{{ route('articles') }}">اخبار و مقالات</a></li>
                                    <li><a href="{{ route('about') }}">درباره ما</a></li>
                                    <li><a href="{{ route('contact') }}">ارتباط با ما</a></li>
                                    <li><a href="{{ route('policy') }}">سیاست حریم خصوصی</a></li>
                                    <li><a href="{{ route('faq') }}">سوالات متداول</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="widgets_container widget_menu">
                            <h3>حساب کاربری</h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="{{ route('user.dashboard') }}">حساب کاربری</a></li>
                                    <li><a href="{{ route('auth') }}">ورود/ثبت نام</a></li>
                                    <li><a href="{{route('cart')}}">سبد خرید </a></li>
                                    <li><a href="{{route('payment')}}">تسویه حساب</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="widgets_container newsletter">
                            <h3>ما را دنبال کنید</h3>
                            <div class="footer_social_link">
                                <ul>
                                    @foreach($data['contact'] as $item)
                                        <li><a class="{{$item['img']}}" href="{{$item['link']}}"><i class="fa fa-{{$item['img']}}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="subscribe_form">
                                <h3>هم اکنون عضو خبرنامه ما شوید</h3>
                                <form id="mc-form" class="mc-form footer-newsletter" method="post">
                                    <input wire:model.defer="email" id="mc-email" type="email" autocomplete="off" placeholder="... آدرس ایمیل شما" dir="ltr">
                                    <button wire:click="registerEmail()" id="mc-submit">اشتراک!</button>
                                </form>
                                <small class="text-secondary">
                                    @error('email')
                                    {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="copyright_area">
                           {{ $data['copyRight'] }}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="footer_payment text-right">
                            <a href="#"><img src="assets/img/icon/payment.png" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--footer area end-->

</div>
