<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--header area start-->

    <!--Offcanvas menu area start-->
    <div class="off_canvars_overlay">
    </div>
    <div class="Offcanvas_menu">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="canvas_open">
                        <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                    </div>
                    <div class="Offcanvas_menu_wrapper">
                        <div class="canvas_close">
                            <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                        </div>
                        <div class="support_info">
                            <p>تلفن تماس: <a class="ltr-text" href="tel:{{$data['tel']}}">{{$data['tel']}}</a></p>
                        </div>
                        <div class="top_right text-right">
                            <ul>
                                @if(auth()->check())
                                    <li><a href="{{ route('user.dashboard') }}"> حساب کاربری </a></li>
                                    @if(auth()->user()->hasRole('admin'))
                                        <li><a href="{{route('admin.dashboard')}}"> مدیریت </a></li>
                                    @endif
                                @else
                                    <li><a href="{{ route('auth') }}"> ورود/ثبت نام </a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="search_container">
                            <form>
                                <div class="hover_category">
                                    <select class="select_option" wire:model.defer="category" name="select" id="categori1">
                                        <option selected value="">همه دسته ها</option>
                                        @foreach($data['categories'] as $category)
                                            @if(is_null($category->parent_id))
                                                <option value="{{$category->slug}}">{{$category->title}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="search_box">
                                    <input  wire:keydown.enter="search()" wire:model.lazy="q" placeholder="جستجوی محصول ..." type="text">
                                    <button wire:click="search()" type="button">جستجو</button>
                                </div>
                            </form>
                        </div>

                        <div class="middel_right_info">
                            <div class="mini_cart_wrapper">
                                <a href="{{ route('cart') }}">
                                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                </a>
                                @if(count(\App\Http\Livewire\Cart\Facades\Cart::content()) > 0)
                                    <span class="cart_quantity">{{ count(\App\Http\Livewire\Cart\Facades\Cart::content()) }}</span>
                                @endif
                            </div>
                        </div>
                        <div id="menu" class="text-left ">
                            <ul class="offcanvas_main_menu">
                                <x-site.nav-item title="صفحه اصلی" link="{{route('home')}}" :active="request()->routeIs('home')" />
                                <x-site.nav-item title="فروشگاه" link="{{route('shop')}}" :active="request()->routeIs('shop')" />
                                <x-site.nav-item title="اخبار و مقالات" link="{{route('articles')}}" :active="request()->routeIs('articles')" />
                                <x-site.nav-item title="سوالات متداول" link="{{route('faq')}}" :active="request()->routeIs('faq')" />
                                <x-site.nav-item title="درباره ما" link="{{route('about')}}" :active="request()->routeIs('about')" />
                                <x-site.nav-item title=" تماس با ما" link="{{route('contact')}}" :active="request()->routeIs('contact')" />
                            </ul>
                        </div>

                        <div class="Offcanvas_footer">
                            <span><a href="mailto:{{ $data['email'] }}"><i class="fa fa-envelope-o"></i> {{ $data['email'] }}</a></span>
                            <ul>
                                @foreach($data['contact'] as $item)
                                    <li><a class="{{$item['img']}}" href="{{$item['link']}}"><i class="fa fa-{{$item['img']}}"></i></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Offcanvas menu area end-->
    <header>
        <div class="main_header">
            <!--header top start-->
            <div class="header_top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="support_info">
                                <p>تلفن تماس: <a class="ltr-text" href="tel:{{$data['tel']}}">{{$data['tel']}}</a></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="top_right text-right">
                                <ul>
                                    @if(auth()->check())
                                        <li><a href="{{ route('user.dashboard') }}"> حساب کاربری </a></li>
                                        @if(auth()->user()->hasRole('admin'))
                                            <li><a href="{{route('admin.dashboard')}}"> مدیریت </a></li>
                                        @endif
                                    @else
                                        <li><a href="{{ route('auth') }}"> ورود/ثبت نام </a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header top start-->
            <!--header middel start-->
            <div class="header_middle">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-6">
                            <div class="logo">
                                <a href="{{ route('home') }}"><img src="{{ asset($data['logo']) }}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-6">
                            <div class="middel_right">
                                <div class="search_container">
                                    <form>
                                        <div class="hover_category">
                                            <select class="select_option" wire:model.defer="category" name="select" id="categori1">
                                                <option selected value="">همه دسته ها</option>
                                                @foreach($data['categories'] as $category)
                                                    <option value="{{$category->slug}}">{{$category->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="search_box">
                                            <input wire:keydown.enter="search()" wire:model.lazy="q" placeholder="جستجوی محصول ..." type="text">
                                            <button wire:click="search()" type="button">جستجو</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="middel_right_info">
                                    <div class="mini_cart_wrapper">
                                        <a href="{{ route('cart') }}">
                                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                        </a>
                                        @if(count(\App\Http\Livewire\Cart\Facades\Cart::content()) > 0)
                                            <span class="cart_quantity">{{ count(\App\Http\Livewire\Cart\Facades\Cart::content()) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header middel end-->
            <!--header bottom satrt-->
            <div class="main_menu_area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-12">
                            <div class="categories_menu {{url()->current() == route('home') ? 'categories_four' : '' }}" wire:ignore>
                                <div class="categories_title">
                                    <h2 class="categori_toggle">دسته‌بندی ها</h2>
                                </div>
                                <div class="categories_menu_toggle">
                                    <ul>
                                        @foreach($data['categories'] as $category)
                                            <li {{ sizeof($category->childrenRecursive) > 0 ? 'class="menu_item_children"' : '' }} >
                                                <a href="{{ route('shop',['category'=>$category->slug]) }}">{{ $category->title }}
                                                    @if(sizeof($category->childrenRecursive) > 0)
                                                        <i class="fa fa-angle-left"></i>
                                                        <ul class="categories_mega_menu">
                                                            @foreach($category->childrenRecursive as $item)
                                                                <li class="menu_item_children">
                                                                    <a href="{{ route('shop',['category'=>$item->slug]) }}">{{ $item->title }}</a>
                                                                    @if(sizeof($item->childrenRecursive) > 0)
                                                                        <ul class="categorie_sub_menu">
                                                                            @foreach($item->childrenRecursive as $value)
                                                                                <li><a href="{{ route('shop',['category'=>$value->slug]) }}">{{ $value->title }}</a></li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <div class="main_menu menu_position">
                                <nav>
                                    <ul>
                                        <x-site.nav-item title="صفحه اصلی" link="{{route('home')}}" :active="request()->routeIs('home')" />
                                        <x-site.nav-item title="فروشگاه" link="{{route('shop')}}" :active="request()->routeIs('shop')" />
                                        <x-site.nav-item title="اخبار و مقالات" link="{{route('articles')}}" :active="request()->routeIs('articles')" />
                                        <x-site.nav-item title="سوالات متداول" link="{{route('faq')}}" :active="request()->routeIs('faq')" />
                                        <x-site.nav-item title="درباره ما" link="{{route('about')}}" :active="request()->routeIs('about')" />
                                        <x-site.nav-item title=" تماس با ما" link="{{route('contact')}}" :active="request()->routeIs('contact')" />
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header bottom end-->
        </div>
    </header>
    <!--header area end-->
    <!--sticky header area start-->
    <div class="sticky_header_area sticky-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="{{route('home')}}"><img src="{{ asset($data['logo']) }}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="sticky_header_right menu_position">
                        <div class="main_menu">
                            <nav>
                                <ul>
                                    <x-site.nav-item title="صفحه اصلی" link="{{route('home')}}" :active="request()->routeIs('home')" />
                                    <x-site.nav-item title="فروشگاه" link="{{route('shop')}}" :active="request()->routeIs('shop')" />
                                    <x-site.nav-item title="اخبار و مقالات" link="{{route('articles')}}" :active="request()->routeIs('articles')" />
                                    <x-site.nav-item title="سوالات متداول" link="{{route('faq')}}" :active="request()->routeIs('faq')" />
                                    <x-site.nav-item title="درباره ما" link="{{route('about')}}" :active="request()->routeIs('about')" />
                                    <x-site.nav-item title=" تماس با ما" link="{{route('contact')}}" :active="request()->routeIs('contact')" />
                                </ul>
                            </nav>
                        </div>
                        <div class="middel_right_info">
                            <div class="mini_cart_wrapper">
                                <a href="{{ route('cart') }}">
                                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                </a>
                                @if(count(\App\Http\Livewire\Cart\Facades\Cart::content()) > 0)
                                    <span class="cart_quantity">{{ count(\App\Http\Livewire\Cart\Facades\Cart::content()) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--sticky header area end-->
</div>
