<div>
    <x-admin.form-control title="{{ $header }}"/>
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body">
            <x-admin.forms.input type="text" id="name" label="نام*" wire:model.defer="name"/>
            <x-admin.forms.input type="text" id="user_name" label="نام کاربری*" wire:model.defer="user_name"/>
            <x-admin.forms.input type="text" id="phone" label="شماره همراه*" wire:model.defer="phone"/>
            <x-admin.forms.input type="password" id="password" help="حداقل {{ \App\Models\Setting::getSingleRow('password_length')}} حرف شامل اعداد و حروف" label="گدرواژه" wire:model.defer="password"/>
            <x-admin.form-section label="نقش های من">
                <ul>
                    @foreach($user->roles as $item)
                        <il>
                            <h5>{{$item->name}}</h5>
                            <hr>
                        </il>
                    @endforeach
                </ul>
            </x-admin.form-section>
        </div>
    </div>
</div>
