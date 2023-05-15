<div>
    <x-admin.form-control mode="{{$mode}}" title="کاربران"/>
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body">
            <x-admin.forms.input type="text" id="name" label="نام *" wire:model.defer="name"/>
            <x-admin.forms.input type="text" id="user_name" label="نام کاربری*" wire:model.defer="user_name"/>
            <x-admin.forms.input type="text" id="phone" label="شماره همراه*" wire:model.defer="phone"/>
            <x-admin.forms.dropdown id="status" :data="$data['status']" label="وضعیت*" wire:model.defer="status"/>
            @if($mode == 'create')
                <x-admin.forms.input type="password"  id="password" label="گذرواژه*" wire:model.defer="password"/>
            @endif
            <hr>
            <x-admin.form-section label="نقش">
                <div class="row">
                    @foreach($data['role'] as  $value)
                        <div class="col-2">
                        <x-admin.forms.checkbox label="{{$value['name']}}" id="permissions-{{$value['id']}}" value="{{$value['id']}}" wire:model.defer="roles" wire:model.defer="userRole.{{$value['id']}}" />
                        </div>
                    @endforeach
                </div>
            </x-admin.form-section>
            @if($mode == 'edit')
                <hr>
                <x-admin.form-section label="کیف پول" >
                    <div class="form-group" style="padding: 5px">
                        <div class="form-control" >
                            موجودی کل :
                            {{  number_format($user->balance) }}تومان
                        </div>
                    </div>
                    <x-admin.forms.dropdown id="action" :data="$data['action']" label="عملیات" wire:model.defer="actionWallet"/>
                    <x-admin.forms.input type="number" id="editWallet" label="مبلغ(تومان)" wire:model.defer="editWallet"/>
                    <x-admin.forms.full-text-editor id="walletMessage" label="متن توضیحات" wire:model.defer="walletMessage"/>
                    <x-admin.button content="تایید" class="primary" wire:click="wallet()" />
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>تاریخ</th>
                            <th>مبلغ</th>
                            <th>نوع تراکنش</th>
                            <th>جزئیات</th>
                        </tr>
                        </thead>
                        <tbody wire:sortable="updateFormPosition()">
                        @forelse($userWallet as $item)
                            <tr>
                                <td>
                                    <div class="comment__date">
                                        <span class="comment__date-day">{{Morilog\Jalali\Jalalian::forge($item->created_at)->format('%d')}}</span>
                                        <span class="comment__date-month">{{Morilog\Jalali\Jalalian::forge($item->created_at)->format('%B')}}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap">
                                <span class="flex items-center gap-1"><span class="font-semibold">{{number_format($item->amount)}}</span><span
                                        class="text-sm">تومان</span></span>
                                </td>
                                <td>{{$item->type == \Bavix\Wallet\Models\Transaction::TYPE_WITHDRAW ? 'برداشت' : 'واریز'}}</td>
                                <td>{!! $item->meta['description'] !!}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4">
                                    دیتایی جهت نمایش وجود ندارد
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </x-admin.form-section>
            @endif
            <hr>
            <x-admin.form-section label="مدیریت برنامه کاربران">
                <table class="table-bordered table table-striped">
                    <thead>
                    <tr>
                        <th>شنبه</th>
                        <th>یکشنبه</th>
                        <th>دوشنبه</th>
                        <th>سه شنبه</th>
                        <th>چهار شنبه</th>
                        <th>پنج شنبه</th>
                        <th> جمعه</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><x-admin.forms.input type="text" id="saturday" placeholder="8-15:30" label="" wire:model.defer="saturday"/></td>
                        <td><x-admin.forms.input type="text" id="sunday" placeholder="8-15:30" label="" wire:model.defer="sunday"/></td>
                        <td><x-admin.forms.input type="text" id="monday" placeholder="8-15:30" label="" wire:model.defer="monday"/></td>
                        <td><x-admin.forms.input type="text" id="tuesday" placeholder="8-15:30" label="" wire:model.defer="tuesday"/></td>
                        <td><x-admin.forms.input type="text" id="wednesday" placeholder="8-15:30" label="" wire:model.defer="wednesday"/></td>
                        <td><x-admin.forms.input type="text" id="thursday" placeholder="8-15:30" label="" wire:model.defer="thursday"/></td>
                        <td><x-admin.forms.input type="text" id="friday" placeholder="8-15:30" label="" wire:model.defer="friday"/></td>
                    </tr>
                    </tbody>
                </table>
            </x-admin.form-section>
            @if($mode == 'edit')
                <x-admin.form-section label="اضافه کاری ها">
                    <div class="row">
                        <div class="col-6">
                            <x-admin.forms.date-picker id="start_at" label="از تاریخ"   wire:model.defer="start_at"/>
                        </div>
                        <div class="col-6">
                            <x-admin.forms.date-picker id="end_at" label="تا تاریخ"   wire:model.defer="end_at"/>
                        </div>
                        <div class="col-12 mt-2">
                            <x-admin.button class="btn btn-primary" content="ثبت ضافه کاری" wire:click="newOverTime()" />
                        </div>
                    </div>
                    <x-admin.form-section label="تاریخچها">
                        <table class="table-bordered table table-striped">
                            <thead>
                            <tr>
                                <th>از تاریخ</th>
                                <th>تا تاریخ</th>
                                <th>مسئول</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody wire:sortable="updateFormPosition()">
                            @forelse($overtimes as $item)
                                <tr>
                                    <td>{{ Morilog\Jalali\Jalalian::forge($item->start_at)->format('%d %B %Y - H:i:s') }}</td>
                                    <td>{{ Morilog\Jalali\Jalalian::forge($item->end_at)->format('%d %B %Y - H:i:s') }}</td>
                                    <td>{{ $item->mangers->fullName ?? '' }}</td>
                                    <td>
                                        <x-admin.delete-btn onclick="deleteOvertime({{$item->id}})"  />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="4">
                                        دیتایی جهت نمایش وجود ندارد
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </x-admin.form-section>
                </x-admin.form-section>
                <hr>
                <x-admin.form-section label="ارسال پیام">
                    <x-admin.forms.full-text-editor id="sendMessage" label="متن پیام" wire:model.defer="sendMessage"/>
                    <x-admin.forms.dropdown id="actions" :data="$data['subjectMessage']" label="موضوع" wire:model.defer="subjectMessage"/>
                    <x-admin.button content="ارسال" class="primary" wire:click="sendMessage()" />
                </x-admin.form-section>
                <x-admin.form-section label="تاریخپه" >
                    <table class="table-bordered table table-striped">
                        <thead>
                        <tr>
                            <th>موضوع</th>
                            <th>متن</th>
                            <th>نوع</th>
                            <th>تاریخ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tbody wire:sortable="updateFormPosition()">
                        @forelse($result as $item)
                            <tr>
                                <td>{{ $item->subject ? $item::getSubject()[$item->subject] : 'بدون موضوع' }}</td>
                                <td style="max-width: 400px">{!! $item->content !!}</td>
                                <td>{{ $item::getType()[$item->type] }}</td>
                                <td>
                                    <div class="comment__date">
                                        <span class="comment__date-day">{{Morilog\Jalali\Jalalian::forge($item->created_at)->format('%d')}}</span>
                                        <span class="comment__date-month">{{Morilog\Jalali\Jalalian::forge($item->created_at)->format('%B')}}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4">
                                    دیتایی جهت نمایش وجود ندارد
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        </tbody>
                    </table>
                </x-admin.form-section>
            @endif
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function deleteOvertime(id) {
            Swal.fire({
                title: 'حذف اضافه کاری!',
                text: 'آیا از حذف این حذف اضافه کاری اطمینان دارید؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله'
            }).then((result) => {
                if (result.value) {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'موفیت امیز!',
                            'حذف حساب مورد نظر با موفقیت حذف شد',
                        )
                    }
                @this.call('deleteOverTimer', id)
                }
            })
        }
        function deleteResultItem(id) {
            Swal.fire({
                title: 'حذف پیام!',
                text: 'آیا از حذف پیام اطمینان دارید؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله'
            }).then((result) => {
                if (result.value) {
                @this.call('deleteResult', id)
                }
            })
        }
    </script>
@endpush
