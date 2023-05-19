<head>
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <!-- Favicon -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/animate/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/simple-line-icons/css/simple-line-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/owl.carousel/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/magnific-popup/magnific-popup.min.css')}}">

    <link rel="stylesheet" href="{{asset('vendor/bootstrap-star-rating/css/star-rating.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-star-rating/themes/krajee-fas/theme.min.css')}}">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/theme.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/theme-elements.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/theme-blog.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/theme-shop.css')}}">

    <!-- Current Page CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/rs-plugin/css/settings.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/rs-plugin/css/layers.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/rs-plugin/css/navigation.css')}}">

    <!-- Demo CSS -->


    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/skins/skin-corporate-8.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/skins/default.css')}}">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

    <!-- Head Libs -->
    <script src="{{asset('assets/vendor/modernizr/modernizr.min.js')}}"></script>


{{--    <script src="https://cdn.ckeditor.com/4.13.0/basic/ckeditor.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset(\App\Models\Setting::getSingleRow('logo'))}}">
    @livewireStyles
</head>
