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
                        <a class="primary_img" href="{{route('product',$item->slug)}}"><img src="{{ asset($item['image']) }}" alt="{{$item->slug}}"></a>
                        <a class="secondary_img" href="{{route('product',$item->slug)}}"><img src="{{ asset($item['image']) }}" alt="{{$item->slug}}"></a>
                    </div>
                    <figcaption class="product_content">
                        <div class="price_box">
                            @if(empty($item->form))
                                @if($item->hasReduction())
                                    <span class="old_price">{{ number_format($item->price) }} تومان </span>
                                    <span class="current_price">
                                            {{ number_format($item->price()) }}تومان
                                        </span>
                                @else
                                    <span class="current_price">
                                            {{ number_format($item->price) }}تومان
                                        </span>
                                @endif
                            @else
                                <span class="current_price">
                                        قیمت متغیر
                                    </span>
                            @endif
                        </div>
                        <h3 class="product_name"><a href="{{route('product',$item->slug)}}"> {{ $item['title'] }} </a></h3>
                        <div class="product_ratings">
                            <ul>
                                @for($i = 0;$i<floor($item['score']);$i++)
                                    <li><a><i class="ion-android-star-outline"></i></a></li>
                                @endfor
                            </ul>
                        </div>
                    </figcaption>
                </figure>
            </article>
        @endforeach
    </div>
</div>
