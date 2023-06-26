<div>
    <x-admin.form-control title="تنطیمات پایه"/>
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body">
            <x-admin.forms.input type="text" id="name" label="نام سایت*" wire:model.defer="name"/>
            <x-admin.forms.input type="text" id="title" label="عنوان سایت*" wire:model.defer="title"/>
            <x-admin.forms.lfm-standalone id="logo" label="لوگو سایت*" :file="$logo" required="true" wire:model="logo"/>
            <x-admin.forms.text-area label="متن معرفی" id="miniAbout" wire:model.defer="miniAbout" />
            <x-admin.forms.full-text-editor label="سیاست حریم خصوصی" id="policy" wire:model.defer="policy" />
            <x-admin.forms.lfm-standalone id="waterMark" label="تصویر واتر مارک*" :file="$waterMark" required="true" wire:model="waterMark"/>
            <x-admin.forms.dropdown id="status" :data="$data['status']" label="وضعیت سایت*" wire:model.defer="status"/>
            <x-admin.forms.input type="text" id="registerGift" label="هدیه ثبت نام(تومان)" wire:model.defer="registerGift"/>
            <x-admin.forms.text-area label="توضیحات سئو*" id="seoDescription" wire:model.defer="seoDescription" />
            <x-admin.forms.text-area label="کلمات سئو*" help="کلمات را با کاما از هم جدا کنید" id="seoKeyword" wire:model.defer="seoKeyword" />
            <x-admin.forms.input type="text" id="notification" label="اعلان بالای صفحه" wire:model.defer="notification"/>
            <x-admin.forms.input type="text" id="tel" label="تلفن*" wire:model.defer="tel"/>
            <x-admin.forms.input type="email" id="email" label="ایمیل*" wire:model.defer="email"/>
            <x-admin.forms.input type="text" id="address" label="ادرس" wire:model.defer="address"/>
            <x-admin.forms.input type="text" id="office" label="دفتر فروش" wire:model.defer="office"/>
            <x-admin.forms.input type="number" id="password_length" label="حداقل طول پسورد*" wire:model.defer="password_length"/>
            <x-admin.forms.input type="number" id="dos_count" label="حداکثر امکان برای درخواست های پیوسته سمت سرور*" wire:model.defer="dos_count"/>
            <x-admin.button class="primary" content="افزودن لینک ارتباطی" wire:click="addLink()" />

            <x-admin.forms.input type="text" id="start_time" label="تایم کاری شنبه تا چهارشنبه" wire:model.defer="start_time"/>
            <x-admin.forms.input type="text" id="end_time" label="تایم کاری پنجشنبه تا حمعه" wire:model.defer="end_time"/>

            <x-admin.form-section label="لینک های اضافی ستون اول">
                <div class="border p-3">
                    <x-admin.button class="btn btn-light-primary font-weight-bolder btn-sm" content="افزودن لینک" wire:click="addLinksR()" />
                    @foreach($linksR as $key => $item)
                        <div class="form-group d-flex align-items-center col-12">
                            <input class="form-control col-5" id="r{{ $key }}link-title" type="text" placeholder="عنوان" wire:model.defer="linksR.{{$key}}.title">
                            <input class="form-control col-5" id="r{{ $key }}link" type="text" placeholder="لینک" wire:model.defer="linksR.{{$key}}.link">
                            <div><button class="btn btn-light-danger font-weight-bolder btn-sm" wire:click="deleteLinksR({{ $key }})">حذف</button></div>
                        </div>
                    @endforeach
                </div>
            </x-admin.form-section>

            <x-admin.form-section label="لینک های اضافی ستون دوم">
                <div class="border p-3">
                    <x-admin.button class="btn btn-light-primary font-weight-bolder btn-sm" content="افزودن لینک" wire:click="addLinks()" />
                    @foreach($links as $key => $item)
                        <div class="form-group d-flex align-items-center col-12">
                            <input class="form-control col-5" id="{{ $key }}link-title" type="text" placeholder="عنوان" wire:model.defer="links.{{$key}}.title">
                            <input class="form-control col-5" id="{{ $key }}link" type="text" placeholder="لینک" wire:model.defer="links.{{$key}}.link">
                            <div><button class="btn btn-light-danger font-weight-bolder btn-sm" wire:click="deleteLinks({{ $key }})">حذف</button></div>
                        </div>
                    @endforeach
                </div>
            </x-admin.form-section>

            <x-admin.forms.text-area id="copyRight" label="متن کپی رایت*" wire:model.defer="copyRight"/>
            <x-admin.form-section label="موضوعات تیکت">
                <x-admin.button class="primary" content="افزودن موضوع" wire:click="addSubject()" />
                @foreach($subject as $key => $item)
                    <div class="form-group" style="display: flex;align-items: center">
                        <div style="padding: 5px">
                            <input class="form-control" id="{{ $key }}subject" type="text" placeholder="عنوان" wire:model.defer="subject.{{$key}}">
                        </div>
                        <div><button class="btn btn-danger" wire:click="deleteSubject({{ $key }})">حذف</button></div>
                    </div>
                @endforeach
            </x-admin.form-section>
        </div>
    </div>
</div>
