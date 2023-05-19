<!doctype html>
<html class="no-js" lang="fa" dir="rtl">
    @include('livewire.site.layouts.site.head')
    <body class="loading-overlay-showing" data-plugin-page-transition data-loading-overlay data-plugin-options="{'hideDelay': 500}">

    <div class="loading-overlay">
        <div class="bounce-loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <div class="body">
        <livewire:site.layouts.site.header />
        @yield('content')
        <livewire:site.layouts.site.footer />
        @include('livewire.site.layouts.site.foot')
    </div>

    </body>
</html>
