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
                                        ادرس
                                    </h3>
                                    <form wire:submit.prevent="store" class="form row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <x-admin.forms.dropdown id="province" label="استان*" :data="$data['province']" wire:model="province" />
                                            @error('province')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6 col-lg-6 col-md-6">
                                            <x-admin.forms.dropdown id="city" label="شهر*" :data="$data['city']" wire:model.defer="city" />
                                            @error('city')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <x-admin.forms.text-area id="address" label="ادرس*"  wire:model.defer="fullAddress" />
                                            @error('fullAddress')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6 col-lg-6 col-md-6">
                                            <x-admin.forms.input type="text" id="postal_code" label="کد پستی*"  wire:model.defer="postal_code" />
                                            @error('postal_code')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6 col-lg-6 col-md-6">
                                            <x-admin.forms.input type="text" id="name" label="نام کامل*"  wire:model.defer="name" />
                                            @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <x-admin.forms.input type="text" id="phone" label="شماره همراه*"  wire:model.defer="phone" />
                                            @error('phone')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <x-admin.forms.checkbox id="active" label="تنظیم به عنوان ادرس پیشفرض"  wire:model.defer="active" />
                                            @error('active')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">دخیره تغییرات</button>
                                            </div>
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
</div>
