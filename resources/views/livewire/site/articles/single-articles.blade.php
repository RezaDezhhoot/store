<div>
    <x-site.breadcrumbs :data="$address" />

    <div class="blog_details mt-60">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <!--blog grid area start-->
                    <div class="blog_wrapper">
                        <article class="single_blog">
                            <figure>
                                <div class="post_header">
                                    <h3 class="post_title">{{ $article->title }}</h3>
                                    <div class="blog_meta">
                                        <span class="author">ارسال توسط : <a>{{ $article->user->user_name }}</a> / </span>
                                        <span class="post_date">در : <a>{{ $article->date }}</a> /</span>
                                    </div>
                                </div>
                                <div class="blog_thumb">
                                    <a><img src="{{ asset($article->main_image) }}" alt="{{ $article->title }}"></a>
                                </div>
                                <figcaption class="blog_content">
                                    <div class="post_content">
                                        {!! $article->content !!}
                                    </div>
                                    <div class="entry_content">
                                        <div class="post_meta">
                                            <span>برچسب ها: </span>
                                            @foreach(explode(',',$article->seo_keywords) as $item)
                                                <span><a href="{{ route('articles',['q'=>$item]) }}">، {{ $item }}</a></span>
                                            @endforeach
                                        </div>

                                        <div class="social_sharing">
                                            <p>اشتراک گذاری این مطلب:</p>
                                            <ul>
                                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" title="facebook"><i class="fa fa-facebook"></i></a></li>
                                                <li><a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" title="twitter"><i class="fa fa-twitter"></i></a></li>
                                                <li><a href="https://t.me/share/url?url={{ url()->current() }}" title="telegram"><i class="fa fa-telegram"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </figcaption>
                            </figure>
                        </article>
                        <div class="related_posts">
                            <h3>مطالب مرتبط</h3>
                            <div class="row">
                                @foreach($related as $item)
                                    <div class="col-lg-4 col-md-6">
                                        <article class="single_related">
                                            <figure>
                                                <div class="related_thumb">
                                                    <img src="{{asset($item->main_image)}}" alt="{{ $item->title }}">
                                                </div>
                                                <figcaption class="related_content">
                                                    <div class="blog_meta">
                                                        <span class="author">توسط: <a>{{ $item->user->user_name }}</a> / </span>
                                                        <span class="post_date"> {{ $item->user->date }}	</span>
                                                    </div>
                                                    <h4><a href="{{ route('article',$item->slug) }}">{{ $item->title }}</a></h4>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="comments_box">
                            <h3>{{ $comments->count() <= 0 ? 'بدون' : $comments->count()  }} دیدگاه	</h3>
                            @foreach($comments as $item)
                                <div class="comment_list">
                                    <div class="comment_thumb">
                                        <img src="{{asset('assets/img/blog/comment3.png.jpg')}}" alt="">
                                    </div>
                                    <div class="comment_content">
                                        <div class="comment_meta">
                                            <h5><a>{{ $item->user->user_name }}</a></h5>
                                            <span>{{ $item->date }}</span>
                                        </div>
                                        <p>
                                            {!! $item->comment !!}
                                        </p>
                                    </div>

                                </div>
                                @if(!is_null($item->answer))
                                    <div class="comment_list list_two">
                                        <div class="comment_thumb">
                                            <img src="{{asset('assets/img/blog/comment3.png.jpg')}}" alt="">
                                        </div>
                                        <div class="comment_content">
                                            <div class="comment_meta">
                                                <h5><a>پشتیبانی</a></h5>
                                                <span>{{ $item->updateDate }}</span>
                                            </div>
                                            <p>
                                                {!! $item->answer !!}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="comments_form">
                            <h3>یک دیدگاه ارسال کنید </h3>
                            <form>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="review_comment">دیدگاه </label>
                                        <textarea wire:model.defer="newComment" name="comment" id="review_comment"></textarea>
                                        @error('newComment')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="g-recaptcha d-inline-block" data-sitekey="{{ config('services.recaptcha.site_key') }}"
                                             data-callback="reCaptchaCallback" wire:ignore></div>
                                        @error('recaptcha')
                                        <p class="invalid-feedback d-block">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                </div>
                                <button class="button" wire:click="sendComment()" type="button">ارسال دیدگاه</button>

                            </form>
                        </div>

                    </div>
                    <!--blog grid area start-->
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

