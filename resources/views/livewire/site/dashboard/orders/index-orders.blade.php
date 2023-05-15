<div>
    <x-site.breadcrumbs :data="$address" />
    <section class="main_content_area">
        <div class="container">
            <div class="account_dashboard">
                <div class="row">
                    @include('livewire.site.dashboard.layouts.sidebar')
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade show active" id="dashboard">
                                <div class="table-responsive">
                                    <h5>سفارش ها</h5>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>کد پیگیری سبد</th>
                                            <th>محصولات</th>
                                            <th>وضعیت</th>
                                            <th>تاریخ</th>
                                            <th>مشاهده</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-black">
                                        @foreach($orders as $item)
                                            <tr>
                                                <td>{{ $item->tracking_code }}</td>
                                                <td>
                                                    @foreach($item->details as $value)
                                                        <a class="btn-link" href="{{ route('product',$value->product->slug) }}">{{$value->product->title}}</a>
                                                    @endforeach
                                                </td>
                                                <td>{{ $item->status_label }}</td>
                                                <td>{{ $item->date }}</td>
                                                <td><a href="{{ route('user.order',$item->id) }}">مشاهده</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{$orders->links('livewire.site.layouts.site.paginate')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
