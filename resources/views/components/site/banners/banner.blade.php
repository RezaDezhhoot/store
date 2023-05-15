@props(['data'])
<div class="banner_area mb-70">
    <div class="single_banner">
        <div class="banner_thumb">
            <a href="{{$data['bannerLink']}}"><img class="w-100" src="{{ asset($data['bannerImage']) }}" alt="{{$data['title']}}"></a>
        </div>
    </div>
</div>
