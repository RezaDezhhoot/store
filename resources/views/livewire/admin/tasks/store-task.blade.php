<div>
    <x-admin.form-control deleteAble="true" deleteContent="حذف وظیفه" mode="{{$mode}}" title="وظیفه"/>
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body">
            <x-admin.forms.input type="text" id="name" label="عنوان*" wire:model.defer="name"/>
            <x-admin.forms.dropdown id="event" :data="$data['event']" label="رویداد*" wire:model.defer="event"/>
            <x-admin.forms.dropdown id="where" :data="$data['task']" label="شرط*" wire:model.defer="where"/>
            <x-admin.form-section label=" کد ها">
                <div class="row">
                    @foreach($data['code'] as $c => $item)
                        <div class="col-lg-2">
                            <p>
                                {{ $c }}
                                <br>
                                <span class="text-info">{{ $item }}</span>
                            </p>
                        </div>
                    @endforeach
                </div>
            </x-admin.form-section>
            <x-admin.forms.text-area label="متن*" wire:model.defer="value" id="value" />
            <x-admin.form-section label="راهنمایی کد ها">
                <div class="form-group">
                    <ul>
                        <li>
                            <span>
                                کد های {*_user} و {time} و {date}  در همه حالات قابل استفاده می باشند.
                            </span>
                        </li>
                        <li>
                            <span>
                                کد های {*_order} و {*_orderDetail} و {*_send} و {*_product} در موارد مرتبط با سفارش ها  قابل استفاده می باشند.
                            </span>
                        </li>
                        <li>
                            <span>
                                کد های {*_ticket} در موارد مرتبط با تیکت ها قابل استفاده می باشند.
                            </span>
                        </li>
                    </ul>
                </div>
            </x-admin.form-section>
        </div>
    </div>
</div>
