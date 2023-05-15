@include('livewire.site.layouts.site.head')
<div class="error_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="error_form">
                    <h1>500</h1>
                    <h2> صفحه مورد نطر خظا دارد</h2>
                    <p>متاسفانه این صفحه دارای خطای ناشناخته می باشد</p>
                    <br>
                    <a href="{{ route('home') }}">بازگشت به صفحه خانه</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--error section area end-->
@include('livewire.site.layouts.site.foot')
