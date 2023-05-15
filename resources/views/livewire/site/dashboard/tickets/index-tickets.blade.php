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
                                <h3 class="text-dark-75">
                                     پشتیبانی
                                </h3>
                                <a class="btn btn-link" href="{{ route('user.ticket',['create']) }}">درخواست جدید</a>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>موضوع</th>
                                            <th>وضعیت</th>
                                            <th>الویت</th>
                                            <th>تاریخ</th>
                                            <th>عملیات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($tickets as $value)
                                            <tr>
                                                <td>{{ $value->subject }}</td>
                                                <td>{{ $value::getStatus()[$value->status] }}</td>
                                                <td>{{ $value::getPriority()[$value->priority] }}</td>
                                                <td>{{ $value->date }}</td>
                                                <td>
                                                    <a  href="{{ route('user.ticket',['edit',$value->id]) }}">مشاهده</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <td class="text-center" colspan="7">
                                                داده ای جهت نمایش وجود ندارد
                                            </td>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{$tickets->links('livewire.site.layouts.site.paginate')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
