<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="customer_login mt-60">
        <div class="container">
            <div class="row">
                <!--login area start-->
                <div class="col-12">
                    <div class="account_form">
                        <h2>ورود</h2>
                        <form wire:submit.prevent="login">
                            <div class="form-group">
                                <label for="phone">نام کاربری یا شماره همراه <span>*</span></label>
                                <input type="text" id="phone" class="form-control" placeholder="نام کاربری" required="" wire:model.defer="phone" />
                                @error('phone')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{$passwordLabel}} <span>*</span></label>
                                <input id="password" type="password" class="form-control" placeholder="رمز ورود" required="" wire:model.defer="password" />
                                @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="login_submit">
                                <div class="row">
                                    <div class="col-12 ">
                                        @if($sms === true)
                                            <span class="text-success" style="float: right">رمز یکبار مصرف برای شمار ارسال شد</span>
                                        @else
                                            <a style="float: right" wire:click="sendSMS">ارسال رمز یکبار مصرف</a>
                                        @endif
                                    </div>
                                    <br>
                                    <div class="col-12">
                                        <a style="float: right" href="{{ route('auth',['mode'=>'register']) }}">قبت نام نکرده اید؟ هم اکنون ثبت نام کنید</a>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">ورود</button>
                            </div>

                        </form>
                    </div>
                </div>
                <!--login area start-->
            </div>
        </div>
    </div>
</div>
