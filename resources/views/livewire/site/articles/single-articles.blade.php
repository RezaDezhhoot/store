<div>
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="text-dark font-weight-bold text-8">{{ $article->title }}</h1>
                        <span class="sub-title text-dark">{{ $article->sub_title }}</span>
                    </div>

                    <div class="col-md-12 align-self-center order-1">
                        <x-site.breadcrumbs :data="$address" />
                    </div>
                </div>
            </div>
        </section>

        <div class="container py-4">

            <div class="row">
                <div class="col">
                    <div class="blog-posts single-post">

                        <article class="post post-large blog-single-post border-0 m-0 p-0">
                            <div class="post-image ml-0">
                                <a>
                                    <img src="{{asset($article->main_image)}}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="{{$article->title}}">
                                </a>
                            </div>

                            <div class="post-date ml-0">
                                <span class="day">{{$article->day}}</span>
                                <span class="month">{{$article->month}}</span>
                            </div>

                            <div class="post-content ml-0">

                                <h2 class="font-weight-bold mt-n3 mb-2 pb-1 pt-1 line-height-7 text-7"><a>{{$article->title}}</a></h2>

                                <div class="post-meta">
                                    <span><i class="far fa-user"></i> توسط  <a >{{ $article->user->user_name }}</a> </span>
                                    <span><i class="far fa-folder"></i>
                                        @foreach(explode(',',$article->seo_keywords) as $item)
                                            <a href="{{ route('articles',['q'=>$item]) }}">، {{ $item }}</a>
                                        @endforeach
                                    </span>
                                </div>

                                {!! $article->content !!}

                                <div class="post-block mt-5 post-share">
                                    <h4 class="mb-3 secondary-font">به اشتراک گذاری این مطلب</h4>

                                    <!-- AddThis Button BEGIN -->
                                    <div class=" ">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"  class="addthis_button_facebook_like" fb:like:layout="button_count">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" class="addthis_button_tweet">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a  href="https://t.me/share/url?url={{ url()->current() }}" class="addthis_button_telegram">
                                            <i class="fab fa-telegram"></i>
                                        </a>
                                    </div>
                                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50faf75173aadc53"></script>
                                    <!-- AddThis Button END -->

                                </div>

                                @if($article->type == \App\Models\Article::ARTICLE)
                                <div id="comments" class="post-block mt-5 post-comments">
                                    <h4 class="mb-3 secondary-font">{{ $comments->count() <= 0 ? 'بدون' : $comments->count()  }} دیدگاه</h4>

                                    <ul class="comments">
                                        @foreach($comments as $item)
                                            <li>
                                                <div class="comment">
                                                    <div class="img-thumbnail img-thumbnail-no-borders d-none d-sm-block">
                                                        <i class="fa fa-4x fa-user"></i>
                                                    </div>
                                                    <div class="comment-block">
                                                        <div class="comment-arrow"></div>
                                                        <span class="comment-by">
																<strong>{{ $item->user->user_name }}</strong>
															</span>
                                                        {!! $item->comment !!}
                                                        <span class="date float-right">{{ $item->date }}</span>
                                                    </div>
                                                </div>
                                                @if(!is_null($item->answer))
                                                    <ul class="comments reply">
                                                        <li>
                                                            <div class="comment">
                                                                <div class="img-thumbnail img-thumbnail-no-borders d-none d-sm-block">
                                                                    <i class="fa fa-4x fa-user"></i>
                                                                </div>
                                                                <div class="comment-block">
                                                                    <div class="comment-arrow"></div>
                                                                    <span class="comment-by">
																		<strong>پشتیبانی </strong>
																	</span>
                                                                    <p>
                                                                        {!! $item->answer !!}
                                                                    </p>
                                                                    <span class="date float-right">{{ $item->updateDate }}</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>

                                <div class="post-block mt-5 post-leave-comment">
                                    <h4 class="mb-3 secondary-font pb-1">دیدگاه خود را بیان کنید</h4>
                                    <form class="contact-form p-4 rounded bg-color-grey">
                                        <div class="p-2">
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label class="required font-weight-bold text-dark text-1-05em">دیدگاه</label>
                                                    <textarea maxlength="5000" data-msg-required="لطفا پیام خود را وارد کنید." rows="8" class="form-control" wire:model.defer="newComment" name="comment" id="review_comment" required></textarea>
                                                    @error('newComment')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <div class="g-recaptcha d-inline-block" data-sitekey="{{ config('services.recaptcha.site_key') }}"
                                                         data-callback="reCaptchaCallback" wire:ignore></div>
                                                    @error('recaptcha')
                                                    <p class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col mb-0">
                                                    <input class="button" wire:click="sendComment()" type="button" value="ارسال دیدگاه" class="btn btn-primary btn-modern" data-loading-text="در حال بارگذاری ...">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </article>

                    </div>
                </div>
            </div>

        </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function reCaptchaCallback(response) {

        @this.set('recaptcha', response);

        }

        Livewire.on('resetReCaptcha', () => {

            grecaptcha.reset();

        });

    </script>
</div>
</div>
