<div>
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="text-dark font-weight-bold text-8">مقالات</h1>
                        <span class="sub-title text-dark">آخرین اخبار ما را مطالعه کنید</span>
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
                    <div class="blog-posts">

                        <div class="row">

                            @foreach($data['articles'] as $item)
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <article class="post post-medium border-0 pb-0 mb-5">
                                        <div class="post-image">
                                            <a href="{{route('article',$item->slug)}}">
                                                <img src="{{ asset($item->main_image) }}" class="img-fluid w-100 img-thumbnail img-thumbnail-no-borders rounded-0" alt="{{ $item->title }}">
                                            </a>
                                        </div>

                                        <div class="post-content">

                                            <h2 class="font-weight-semibold text-5 line-height-7 mt-3 mb-2 pt-1"><a href="{{route('article',$item->slug)}}">{{ $item->title }}</a></h2>
                                            <p>{{ $item->sub_title }}</p>

                                            <div class="post-meta">
                                                <span><i class="far fa-comments"></i> <a>{{ $item->date }}</a></span>
                                                <span class="d-block mt-2 pt-1"><a href="{{route('article',$item->slug)}}" class="btn btn-xs btn-light text-1 text-uppercase">بیشتر بخوانید</a></span>
                                            </div>

                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                        {{$data['articles']->links('livewire.site.layouts.site.paginate')}}
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
