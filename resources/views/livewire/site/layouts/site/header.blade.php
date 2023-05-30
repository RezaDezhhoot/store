<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--header area start-->
    <header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 164, 'stickySetTop': '-164px', 'stickyChangeLogo': false}">
        <div class="header-body border-0">
            <div class="header-top header-top-default border-bottom-0 bg-color-primary">
                <div class="container">
                    <div class="header-row py-2">
                        <div class="header-column justify-content-start">
                            <div class="header-row">
                                <nav class="header-nav-top">
                                    <ul class="nav nav-pills text-uppercase text-2">
                                        <li class="nav-item nav-item-anim-icon">
                                            <a class="nav-link pl-0 text-light opacity-7" href="{{route('about')}}"><i class="fas fa-angle-left"></i> درباره ما</a>
                                        </li>
                                        <li class="nav-item nav-item-anim-icon">
                                            <a class="nav-link text-light opacity-7 pr-0" href="{{route('contact')}}"><i class="fas fa-angle-left"></i> تماس با ما</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="header-column justify-content-end">
                            <div class="header-row">
                                <ul class="header-social-icons social-icons d-none d-sm-block social-icons-clean social-icons-icon-light">
                                    @foreach($data['contact'] as $item)
                                        <li class="social-icons-{{$item['img']}}"><a target="_blank" href="{{$item['link']}}"><i class="fab fa-{{$item['img']}}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-container container">
                <div class="header-row py-3">
                    <div class="header-column justify-content-start w-50 order-md-1 d-none d-md-flex">
                        <div class="header-row">
                            <ul class="header-extra-info">
                                <li class="m-0">
                                    <div class="feature-box feature-box-style-2 align-items-center">
                                        <div class="">
                                            <img class="p-relative w-50 top-1" alt="لوگو" src="{{asset($data['logo'])}}">
                                            <br>
                                            <p class="pb-0 font-weight-semibold text-2">
                                                {{$data['title']}}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-column justify-content-start justify-content-md-center order-1 order-md-2">
                        <div class="header-row">
                            <div class="header-logo">
                                <a href="{{route('home')}}">
                                    <img alt="لوگو" src="{{asset($data['logo'])}}">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="header-column justify-content-end w-50 order-2 order-md-3">
                        <div class="header-row">
                            <ul class="header-extra-info">
                                <li class="m-0">
                                    <div class="feature-box reverse-allres feature-box-style-2 align-items-center">
                                        <div class="feature-box-icon">
                                            <i class="fab fa-whatsapp text-7 p-relative"></i>
                                        </div>
                                        <div class="feature-box-info">
                                            <p class="pb-0 font-weight-semibold text-2"><span class="ltr-text">{{$data['tel']}}</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-nav-bar header-nav-bar-top-border bg-light">
                <div class="header-container container">
                    <div class="header-row">
                        <div class="header-column">
                            <div class="header-row justify-content-end">
                                <div class="header-nav p-0">
                                    <div class="header-nav header-nav-line header-nav-divisor header-nav-spaced justify-content-lg-center">
                                        <div class="header-nav-main header-nav-main-square header-nav-main-effect-1 header-nav-main-sub-effect-1">
                                            <nav class="collapse">
                                                <ul class="nav nav-pills flex-column flex-lg-row" id="mainNav">
                                                    <li class="dropdown">
                                                        <a class="dropdown-item dropdown-toggle {{request()->routeIs('home') ? 'active' : ''}}" href="{{route('home')}}">
                                                            صفحه نخست
                                                        </a>
                                                    </li>
                                                    <li class="dropdown">
                                                        <a class="dropdown-item dropdown-toggle {{request()->routeIs('shop') ? 'active' : ''}}" href="{{route('shop')}}">
                                                            محصولات
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li class="dropdown-submenu">
                                                                <a class="dropdown-item" href="{{route('cart')}}">سبد خرید</a>
                                                                <a class="dropdown-item" href="{{route('checkout')}}">تسویه حساب</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="dropdown">
                                                        @if(auth()->check())
                                                            <a class="dropdown-item dropdown-toggle" href="{{ route('user.dashboard') }}"> حساب مشتریان </a>
                                                            <ul class="dropdown-menu">
                                                                @if(auth()->user()->hasRole('admin'))
                                                                    <li class="dropdown-item"><a class="dropdown-item" href="{{route('admin.dashboard')}}"> مدیریت </a></li>
                                                                @endif
                                                                <li class="dropdown-item"><a class="dropdown-item" href="{{route('logout')}}"> خروج </a></li>
                                                            </ul>
                                                        @else
                                                            <a class="dropdown-item dropdown-toggle {{request()->routeIs('auth') ? 'active' : ''}}" href="{{ route('auth') }}"> حساب مشتریان </a>
                                                        @endif
                                                    </li>
                                                    <li class="dropdown">
                                                        <a class="dropdown-item dropdown-toggle {{request()->routeIs('contact') ? 'active' : ''}}" href="{{route('contact')}}">
                                                            تماس با ما
                                                        </a>
                                                    </li>
                                                    <li class="dropdown">
                                                        <a class="dropdown-item dropdown-toggle {{request()->routeIs('about') ? 'active' : ''}}" href="{{route('about')}}">
                                                            درباره ما
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                        <button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main nav">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>
