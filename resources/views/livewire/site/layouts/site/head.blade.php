<head>
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>قالب Junko</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS
    ========================= -->

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">


{{--    <script src="https://cdn.ckeditor.com/4.13.0/basic/ckeditor.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset(\App\Models\Setting::getSingleRow('logo'))}}">
    @livewireStyles
</head>
