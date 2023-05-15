<div>
   <div wire:ignore>
       <x-site.breadcrumbs :data="$address" />
   </div>

    <div class="blog_page_section blog_reverse mt-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-3" wire:ignore>
                    <div class="blog_sidebar_widget">
                        <div class="widget_list widget_search">
                            <h3>جستجو</h3>
                                <input wire:model.defer="q" wire:keydown.enter="updateQ()" placeholder="جستجو ..." type="text">
                                <button wire:click="updateQ()" type="button">جستجو</button>
                        </div>
                        <div class="widget_list widget_post">
                            <h3>مطالب اخیر</h3>
                            @foreach($lastPosts as $item)
                                <div class="post_wrapper">
                                    <div class="post_thumb">
                                        <a href="{{route('article',$item->slug)}}">
                                            <img src="{{ asset($item->main_image) }}" alt="{{ $item->title }}">
                                        </a>
                                    </div>
                                    <div class="post_info">
                                        <h3><a href="{{route('article',$item->slug)}}">{{ $item->title }}</a></h3>
                                        <span>{{ $item->date }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="widget_list widget_categories">
                            <h3>دسته ها</h3>
                            <ul>
                                <li><a wire:click="$set('category','')">همه</a></li>
                                @foreach($categories as $item)
                                    <li><a wire:click="$set('category','{{$item->slug}}')">{{ $item->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="blog_wrapper blog_wrapper_sidebar">
                        <div class="blog_header">
                            <h1>اخبار و مقالات</h1>
                        </div>
                        <div class="row">
                            @foreach($data['articles'] as $article)
                                <div class="col-lg-6 col-md-6">
                                    <article class="single_blog mb-60">
                                        <figure>
                                            <div class="blog_thumb">
                                                <a href="{{route('article',$article->slug)}}">
                                                    <img src="{{ asset($article->main_image) }}" alt="{{$article->title}}">
                                                </a>
                                            </div>
                                            <figcaption class="blog_content">
                                                <h3><a href="{{route('article',$article->slug)}}">{{$article->title}}</a></h3>
                                                <div class="blog_meta">
                                                    <span class="author">ارسال توسط : <a>{{$article->user->user_name}}</a> / </span>
                                                    <span class="post_date">در : <a href="#">{{ $article->date }}</a></span>
                                                </div>
                                                <footer class="readmore_button">
                                                    <a href="{{route('article',$article->slug)}}">بیشتر بخوانید</a>
                                                </footer>
                                            </figcaption>
                                        </figure>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{$data['articles']->links('livewire.site.layouts.site.paginate')}}
                </div>
            </div>
        </div>
    </div>


</div>
