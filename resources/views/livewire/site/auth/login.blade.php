<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col">
            <div class="featured-boxes">
                <div class="row">
                    <div class="col-12 col-lg-8 mx-auto">
                        <div class="featured-box featured-box-primary text-left mt-2">
                            <div class="box-content">
                                <h4 class="color-primary font-weight-semibold text-4 text-uppercase mb-3">فرم ورود به پنل</h4>
                                <form wire:submit.prevent="login">
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label class="font-weight-bold text-dark text-2">نام کاربری یا شماره همراه</label>
                                            <input type="text"  required="" wire:model.defer="phone"  value="" id="phone" class="form-control form-control-lg text-left" dir="ltr">
                                            @error('phone')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label class="font-weight-bold text-dark text-2">رمز عبور</label>
                                            <input type="password" wire:model.defer="password" id="password" value="" class="form-control form-control-lg text-left" dir="ltr">
                                            @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <div class="col-12">
                                                <a  href="{{ route('auth',['mode'=>'register']) }}">قبت نام نکرده اید؟ هم اکنون ثبت نام کنید</a>
                                            </div>
                                            <div>
                                                <input type="submit" value="ورود" class="btn btn-primary" data-loading-text="در حال بارگذاری ...">
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
