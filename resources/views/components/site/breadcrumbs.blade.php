@props(['data'])
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        @foreach($data as $item)
                            <li><a {{ !empty($item['link']) ? "href=".$item['link']."" : '' }} >{{ $item['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
