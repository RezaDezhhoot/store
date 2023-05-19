@props(['data'])
<ul class="breadcrumb d-block text-center">
    @foreach($data as $item)
        <li><a {{ !empty($item['link']) ? "href=".$item['link']."" : '' }} >{{ $item['label'] }}</a></li>
    @endforeach
</ul>
