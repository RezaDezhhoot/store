<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col">
            <div class="featured-boxes">
                <div class="row">
                    <div class="col-12 col-lg-8 mx-auto">
                        <div class="featured-box featured-box-primary text-left mt-2">
                            <div class="box-content">
                                <h4 class="color-primary font-weight-semibold text-4 text-uppercase mb-3">ثبت نام</h4>
                                <form wire:submit.prevent="register">
                                    <div class="form-row">
                                        <div class="form-group col-12 col-lg-6">
                                            <label class="font-weight-bold text-dark text-2">نام کامل</label>
                                            <input type="text"  required="" wire:model.defer="name"  value="" id="name" class="form-control form-control-lg text-left" dir="ltr">
                                            @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label class="font-weight-bold text-dark text-2">شماره همراه</label>
                                            <input type="text"  required="" wire:model.defer="phone_number"  value="" id="phone_number" class="form-control form-control-lg text-left" dir="ltr">
                                            @error('phone_number')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label class="font-weight-bold text-dark text-2">رمز عبور</label>
                                            <input type="password" wire:model.defer="password" id="password" value="" class="form-control form-control-lg text-left" dir="ltr">
                                            @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12 col-lg-6">
                                            <label class="font-weight-bold text-dark text-2"> تاید رمز عبور</label>
                                            <input type="password" wire:model.defer="password_confirmation" id="password_confirmation" value="" class="form-control form-control-lg text-left" dir="ltr">
                                            @error('password_confirmation')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <div class="col-12">
                                                <a  href="{{ route('auth',['mode'=>'login']) }}">قبلا  قبت نام کرده اید؟ هم اکنون وارد شوید</a>
                                            </div>
                                            <div>
                                                <input type="submit" wire:loading.attr="disabled" value="ثبت نام" class="btn btn-primary" data-loading-text="در حال بارگذاری ...">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
