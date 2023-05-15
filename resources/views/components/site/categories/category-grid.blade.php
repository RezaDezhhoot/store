@props(['data'])
<div class="my-5">
    <div class="section_title">
        <h2>{{$data['title']}}</h2>
    </div>
    <div class="">
        @foreach($data['content'] as $item)
            <div class="col-lg-{{$data['widthCase']}} col-xl-{{$data['widthCase']}} col-xxl-{{$data['widthCase']}} col-md-4 col-sm-6 col-6">
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
