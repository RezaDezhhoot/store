<div xmlns:x-on="http://www.w3.org/1999/xhtml">
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
                                    مرجوعیت
                                </h3>
                                <form wire:submit.prevent="store" class="form row">
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <x-admin.forms.dropdown id="orderBasket" label="سبد سفارش*" :data="$data['orders']" wire:model="orderBasket" />
                                        @error('orderBasket')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <x-admin.forms.dropdown id="order_id" label="محصول*" :data="$data['products']" wire:model.defer="order_id" />
                                        @error('order_id')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <x-admin.forms.basic-text-editor id="content" label="توضیحات*"  wire:model.defer="content" />
                                        @error('content')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <x-admin.form-section label="تصاویر(انتخاب چندتایی)">
                                            <div x-data="{ isUploading: false, progress: 0 }"
                                                 x-on:livewire-upload-start="isUploading = true"
                                                 x-on:livewire-upload-finish="isUploading = false"
                                                 x-on:livewire-upload-error="isUploading = false"
                                                 x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                <input type="file" multiple id="file" wire:model="file" aria-label="file" />
                                                <br>
                                                <div class="mt-2" x-show="isUploading">
                                                    در حال اپلود تصویر...
                                                    <br>
                                                    <progress max="100" x-bind:value="progress"></progress>

                                                    @error('file')
                                                        <br>
                                                        <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex align-items-center">
                                                @if(!is_null($file))
                                                    @foreach($file as $key=> $item)
                                                        <img class="p-3" wire:click="unsetImage({{$key}})" style="max-width: 100px;border-radius: 5px" src="{{ $item->temporaryUrl() }}">
                                                    @endforeach
                                                @endif
                                                @if(!is_null($images))
                                                    @foreach(explode(',',$images) as $item)
                                                        <img  class="p-3" style="max-width: 100px;border-radius: 5px" src="{{asset($item)}}" alt="">
                                                    @endforeach
                                                @endif
                                            </div>
                                            @if(!is_null($file))
                                                برای حذف تصویر روی ان کیلک نمایید
                                            @endif

                                        </x-admin.form-section>
                                    </div>

                                    <div class="col-6 col-lg-6 col-md-6">
                                        <x-admin.forms.input type="text" id="card_number" label="شماره کارت*"  wire:model.defer="card_number" />
                                        @error('card_number')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6 col-lg-6 col-md-6">
                                        <x-admin.forms.input type="text" id="sheba_number" label="شماره شبا*"  wire:model.defer="sheba_number" />
                                        @error('sheba_number')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6 col-lg-6 col-md-6">
                                        <x-admin.forms.input  type="text" id="name" label="به نام*"   wire:model.defer="name" />
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6 col-lg-6 col-md-6">
                                        <x-admin.forms.input  type="number" id="quantity" label="تعداد*" min="1"  wire:model.defer="quantity" />
                                        @error('quantity')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    @if($mode == 'edit')
                                        <div class="col-12">
                                            <span>نتیجه درخواست</span>
                                            {!! $result !!}
                                        </div>
                                    @endif
                                    @if($mode == 'create')
                                    <div class="col-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <button class="btn btn-primary">ثبت</button>
                                            <br>
                                            <p wire:loading>
                                                در حال پردازش...
                                            </p>
                                        </div>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
