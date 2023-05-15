@props(['data'])
<section class="product_area product_four_bottom">
    <div class="section_title">
        <h2>{{$data['title']}}</h2>
    </div>
    <div class="product_carousel product_column4 owl-carousel">
        @foreach($data['content'] as $item)
            <article class="single_blog">
                <figure>
                    <div class="blog_thumb">
                        <a href="{{route('article',[$item->slug])}}"><img src="{{ $item['main_image'] }}" alt="{{$item->slug}}"></a>
                    </div>
                    <figcaption class="blog_content">
                        <p class="post_author">توسط <a> {{ $item->user->name ?? 'مدیر' }} </a>{{ $item->date }}</p>
                        <h3 class="post_title"><a href="{{route('article',[$item->slug])}}">{{ $item->title }}</a></h3>
                    </figcaption>
                </figure>
            </article>
        @endforeach
    </div>
</section>
