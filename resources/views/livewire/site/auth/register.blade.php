<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="customer_login mt-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="account_form register">
                        <h2>ثبت نام</h2>
                        <form wire:submit.prevent="register">
                           <div class="row">
                               <div class="col-12 col-lg-6 col-md-6">
                                   <div class="form-group">
                                       <label for="name">نام کامل <span>*</span></label>
                                       <input wire:model.defer="name" id="name" type="text" class="form-control" placeholder="نام کامل"  />
                                       @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                       @enderror
                                   </div>
                               </div>
                               <div class="col-12 col-lg-6 col-md-6">
                                   <div class="form-group">
                                       <label for="user_name">نام کاربری <span>*</span></label>
                                       <input wire:model.defer="user_name" id="user_name" type="text" class="form-control" placeholder="نام کاربری"  />
                                       @error('user_name')
                                            <span class="text-danger">{{$message}}</span>
                                       @enderror
                                   </div>
                               </div>
                               <div class="col-12">
                                   <div class="form-group">
                                       <label for="phone_number">نام کاربری <span>*</span></label>
                                       <input wire:model.defer="phone_number" id="phone_number" type="text" class="form-control" placeholder="شماره همراه"  />
                                       @error('phone_number')
                                            <span class="text-danger">{{$message}}</span>
                                       @enderror
                                   </div>
                               </div>
                               <div class="col-12 col-lg-6 col-md-6">
                                   <div class="form-group">
                                       <label for="password">رمز عبور <span>*</span></label>
                                       <input wire:model.defer="password" id="password" type="password" class="form-control" placeholder="رمز عبور"  />
                                       @error('password')
                                        <span class="text-danger">{{$message}}</span>
                                       @enderror
                                   </div>
                               </div>
                               <div class="col-12 col-lg-6 col-md-6">
                                   <div class="form-group">
                                       <label for="password_confirmation">تایید رمز عبور <span>*</span></label>
                                       <input wire:model.defer="password_confirmation" id="password_confirmation" type="password" class="form-control" placeholder="رمز عبور"  />
                                       @error('password_confirmation')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror
                                   </div>
                               </div>
                           </div>
                            <div class="login_submit">
                                <div class="row">
                                    <div class="col-12">
                                        <a style="float: right" href="{{ route('auth',['mode'=>'login']) }}">قبلا  قبت نام کرده اید؟ هم اکنون وارد شوید</a>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">قبت نام</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
