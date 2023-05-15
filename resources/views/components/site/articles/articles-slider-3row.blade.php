@props(['data'])
<div class="small_product_area small_product_four">
    <div class="section_title">
        <h2><span> {{$data['title']}} </span></h2>
    </div>
    <div class="small_product_container  small_product_active">
        @foreach($data['content'] as $item)
            <article class="single_product">
                <figure>
                    <div class="product_thumb">
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
</div>
