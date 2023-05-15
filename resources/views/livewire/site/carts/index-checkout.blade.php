<div>
    <x-site.breadcrumbs :data="$address" />
    <div class="Checkout_section mt-60">
        <div class="container">
            <div class="checkout_form">
                <div class="row">
                    <div class="col-12">
                        <form>
                            <h3>جزئیات پرداخت</h3>
                            <div class="order_table table-responsive">
                                <table>
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
                        <a href="{{ route('user.order',$data->id) }}" class="btn btn-light-primary">مشاهد جزییات سفارش</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
