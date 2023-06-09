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
                                    خوش امدی {{ auth()->user()->name }}
                                </h3>
                                <div class="table-responsive">
                                    <h5>تراکنش ها</h5>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>تاریخ</th>
                                            <th>مبلغ</th>
                                            <th>نوع تراکنش</th>
                                            <th>بابت</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-black">
                                        @forelse($transactions as $item)
                                            <tr>
                                                <td>
                                                    <div class="comment__date">
                                                        <span class="comment__date-month">{{Morilog\Jalali\Jalalian::forge($item->created_at)->format('%A, %d %B %Y')}}</span>
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap">
                                                    <span class="flex items-center gap-1"><span class="font-semibold">{{number_format($item->amount)}}</span><span class="text-sm">تومان</span></span>
                                                </td>
                                                <td>{{$item->type == 'withdraw' ? 'برداشت' : 'واریز'}}</td>
                                                <td class="min-w-32">{!! $item->meta['description'] !!}</td>
                                            </tr>
                                        @empty
                                            <td colspan="12">
                                                <p class="alert alert-info">
                                                    هیچ تراکتشی ثبت نشده است
                                                </p>
                                            </td>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{$transactions->links('livewire.site.layouts.site.paginate')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
</div>
