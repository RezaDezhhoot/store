<!doctype html>
<html class="no-js" lang="fa" dir="rtl">
    @include('livewire.site.layouts.site.head')
    <body>
        <livewire:site.layouts.site.header />
        @yield('content')
        <livewire:site.layouts.site.footer />
        @include('livewire.site.layouts.site.foot')
    </body>
</html>
