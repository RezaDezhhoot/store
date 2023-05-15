@props(['data'])
<section class="product_area product_four_bottom">
    <div class="section_title">
        <h2>{{$data['title']}}</h2>
    </div>
    <div class="product_carousel product_column4 owl-carousel">
        @foreach($data['content'] as $item)
            <article class="single_product">
                <figure>
                    <div class="product_thumb">
                        <a class="primary_img" href="{{route('product',$item->slug)}}"><img src="{{ asset($item['image']) }}" alt="{{$item->slug}}"></a>
                        <a class="secondary_img" href="{{route('product',$item->slug)}}"><img src="{{ asset($item['image']) }}" alt="{{$item->slug}}"></a>
                        <div class="action_links">
                            <ul>
                                <li class="wishlist" wire:click="addToWishlist('{{$item->id}}')">
                                    <a  title="افزودن به علاقه‌مندی‌ها">
                                        <i class="fa fa-heart-o text-white"  aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @if($item->hasReduction() && !is_null($item->expire_at))
                            <div class="product_timing" wire:igonre>
                                <div data-countdown="{{ \Carbon\Carbon::make($item->expire_at)->format('Y/m/d') }}"></div>
                            </div>
                        @endif
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
                    </figcaption>
                </figure>
            </article>
        @endforeach
    </div>
</section>
