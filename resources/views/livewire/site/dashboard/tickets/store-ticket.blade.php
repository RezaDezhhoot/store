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
                                    پشتیبانی
                                </h3>
                                <form wire:submit.prevent="store" class="form row">
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <x-admin.forms.dropdown id="subject" label="موضوع*" value="{{true}}" :data="$data['subject']" wire:model.defer="subject" />
                                        @error('subject')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <x-admin.forms.dropdown  id="priority" label="الویت*" :data="$data['priority']" wire:model.defer="priority" />
                                        @error('priority')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <x-admin.forms.basic-text-editor id="content" label="متن درخواست*"  wire:model.defer="content" />
                                    </div>
                                    <div class="col-12 ">
                                        <div class="form-group">
                                            <label class="form-label" for="file">پیوست فایل</label>
                                            <div x-data="{ isUploading: false, progress: 0 }"
                                                 x-on:livewire-upload-start="isUploading = true"
                                                 x-on:livewire-upload-finish="isUploading = false"
                                                 x-on:livewire-upload-error="isUploading = false"
                                                 x-on:livewire-upload-progress="progress = $event.detail.progress">

                                                <input  {{ $disabled ? 'disabled' : '' }} type="file" id="file" wire:model="file" aria-label="file" />
                                                <br>
                                                <small>
                                                    فرمت های مجاز png,jpg,jpeg و
                                                </small>
                                                <small>
                                                    حداکثر تا 2 مگابایت
                                                </small>
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
                                                <div class="col-12 d-flex align-items-center">
                                                    @if(!is_null($file))
                                                        @foreach($file as $key=> $item)
                                                            <img class="p-3" wire:click="unsetImage({{$key}})" style="max-width: 100px;border-radius: 5px" src="{{ $item->temporaryUrl() }}">
                                                        @endforeach
                                                    @endif
                                                    @if(!is_null($files))
                                                        @foreach(explode(',',$files) as $item)
                                                            <img  class="p-3" style="max-width: 100px;border-radius: 5px" src="{{asset($item)}}" alt="">
                                                        @endforeach
                                                    @endif
                                                </div>
                                                @if(!is_null($file))
                                                    برای حذف تصویر روی ان کیلک نمایید
                                                @endif
                                            </div>
                                            @error('file')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @if($mode == 'edit' && !empty($ticket->child))
                                        <div class="col-lg-12 col-md-12">
                                            <legend>تاریخچه</legend>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            @foreach($ticket->child as $item)
                                                <div class="comment_list">
                                                    <div class="comment_thumb">
                                                        <img src="{{asset('assets/img/blog/comment3.png.jpg')}}" alt="">
                                                    </div>
                                                    <div class="comment_content">
                                                        <div class="comment_meta">
                                                            <h5><a> {{ $item->sender->name ?? $item->sender->user_name }}</a></h5>
                                                            <span>{{ $item->date }}</span>
                                                        </div>
                                                        <p>
                                                            {!! $item->content !!}
                                                        </p>
                                                        @if(!empty($ticket->file))
                                                            <a href="{{asset($item->file)}}">مشاهده فایل</a>
                                                        @endif
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <x-admin.forms.basic-text-editor label="پیام جدید" id="newMessage" wire:model.defer="newMessage" />
                                            @error('newMessage')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="newFile">پیوست فایل</label>
                                                <div x-data="{ isUploading: false, progress: 0 }"
                                                     x-on:livewire-upload-start="isUploading = true"
                                                     x-on:livewire-upload-finish="isUploading = false"
                                                     x-on:livewire-upload-error="isUploading = false"
                                                     x-on:livewire-upload-progress="progress = $event.detail.progress">

                                                    <input  multiple type="file" id="newFile" wire:model="newFile" aria-label="newFile" />

                                                    <div class="mt-2" x-show="isUploading">
                                                        لطفا صبر کنید...
                                                        <progress max="100" x-bind:value="progress"></progress>
                                                    </div>
                                                    <br>
                                                    <small>
                                                        فرمت های مجاز png,jpg,jpegو
                                                    </small>
                                                    <small>
                                                        حداکثر تا 2 مگابایت
                                                    </small>
                                                </div>
                                                @error('newFile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-12 col-md-12 mt-3">
                                        <button type="submit" class="btn btn-primary"><span class="label">ذخیره تغییرات</span></button>
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
