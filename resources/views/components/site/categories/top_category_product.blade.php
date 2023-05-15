@props(['data'])
<div class="my-5">
    <div class="section_title">
        <h2>{{$data['title']}}</h2>
    </div>
    <div class="top_category_container category_column5 owl-carousel">
        @foreach($data['content'] as $item)
            <div class="col-lg-2">
                <article class="single_category">
                    <figure>
                        <div class="category_thumb">
                            <a href="{{ route('shop',['category' => $item->slug])}}"><img src="{{asset($item['logo'])}}" alt="{{$item->slug}}"></a>
                        </div>
                        <figcaption class="category_name">
                            <h3><a href="{{ route('shop',['category' => $item->slug])}} ">{{ $item['title'] }} </a></h3>
                        </figcaption>
                    </figure>
                </article>
            </div>
        @endforeach
    </div>

</div>
