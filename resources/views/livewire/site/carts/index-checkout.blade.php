<div>
    <div role="main" class="main shop">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="text-dark font-weight-bold text-8">جزییات پرداخت</h1>
                    </div>

                    <div class="col-md-12 align-self-center order-1">
                        <x-site.breadcrumbs :data="$address" />
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="checkout_form">
                <div class="row">
                    <div class="col-12">
                        <form>
                            <div class="order_table table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td><span>نتیجه پرداخت</span></td>
                                        <td>{{ $message }}</td>
                                    </tr>
                                    <tr>
                                        <td><span>کد رهگیری سفارش</span></td>
                                        <td>{{ $data->tracking_code }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <a href="{{ route('user.order',$data->id) }}" class="btn btn-primary btn-sm">مشاهد جزییات سفارش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
