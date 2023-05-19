<div>
    <div role="main" class="main shop">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 align-self-center order-1">
                        <x-site.breadcrumbs :data="$address" />
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            @if(\App\Http\Livewire\Site\Auth\Auth::MODE_LOGIN == $mode)
                @include('livewire.site.auth.login')
            @elseif(\App\Http\Livewire\Site\Auth\Auth::MODE_REGISTER == $mode)
                @include('livewire.site.auth.register')
            @elseif(\App\Http\Livewire\Site\Auth\Auth::MODE_VERIFY == $mode)
                @include('livewire.site.auth.verify')
            @endif
        </div>

    </div>

</div>
