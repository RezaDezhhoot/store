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
        <section class="main_content_area">
        <div class="container">
            <div class="account_dashboard">
                <div class="row">
                    @include('livewire.site.dashboard.layouts.sidebar')
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade show active" id="dashboard">
                                <h3 class="text-dark-75">
                                    مرجوعی ها
                                </h3>
                                <a class="btn btn-link" href="{{ route('user.return',['create']) }}">درخواست جدید</a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>کد پیگیری سفارش</th>
                                            <th>وضعیت</th>
                                            <th>تاریخ</th>
                                            <th>مشاهده</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-black">
                                        @foreach($returns as $item)
                                            <tr>
                                               <td>{{ $item->order->tracking_code }}</td>
                                               <td>{{ $item->status_label }}</td>
                                               <td>{{ $item->date }}</td>
                                                <td><a href="{{ route('user.return',['edit',$item->id]) }}">مشاهده</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{$returns->links('livewire.site.layouts.site.paginate')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
</div>
