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
                                    جزئیات حساب
                                </h3>
                                <form wire:submit.prevent="store" class="form row">
                                    <div class="col-12">
                                        <x-admin.forms.input type="text" id="name" label="نام*"  wire:model.defer="name" />
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <x-admin.forms.input type="text" id="user_name " label="نام کاربری*"  wire:model.defer="user_name" />
                                        @error('user_name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <h4>تغییر رمز عبور</h4>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <x-admin.forms.input id="password" type="password" label="گذرواژه جدید (خالی بگذارید بدون تغییر)" wire:model.defer="password" />
                                        @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <x-admin.forms.input id="password_confirmation" type="password" label="رمزعبور جدید را تأیید کنید" wire:model.defer="password_confirmation" />
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <button type="submit" class="default-btn"><span class="label">ذخیره تغییرات</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
