@include('livewire.site.layouts.site.head')

<div class="error_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="error_form">
                    <h1>403</h1>
                    <h2>شما اجازه این کار را ندارید</h2>
                    <p>متاسفیم صفحه ای که به دنبال آن هستید محدود شده است.</p>
                    <br>
                    <a href="{{ route('home') }}">بازگشت به صفحه خانه</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--error section area end-->

@include('livewire.site.layouts.site.foot')
