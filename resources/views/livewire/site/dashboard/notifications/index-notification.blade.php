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
                                   اعلان ها
                                </h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>تاریخ</th>
                                            <th>موضوع</th>
                                            <th>اعلان</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-black">
                                        @foreach($notifications as $item)
                                            <tr>
                                                <td>
                                                    <div class="comment__date">
                                                        <span class="comment__date-month">{{Morilog\Jalali\Jalalian::forge($item->created_at)->format('%A, %d %B %Y')}}</span>
                                                    </div>
                                                </td>
                                                <td>{{$item->subject_label}}</td>
                                                <td>{!! $item->content !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{$notifications->links('livewire.site.layouts.site.paginate')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
</div>
