<div >
    <x-site.sliders :data="$data['homeSlider']" />
    <!--hoem section four area start-->
    <div class="home_section_four" wire:ignore>
        <div class="container">
            <div class="row" wire:ignore>
                @foreach($content as $item)
                    <div class="col-lg-{{$item['width']}}">
                        @if($item['category'] <> 'banner')
                            @switch($item['category'])
                                @case('products')
                                    @if($item['type'] == 'slider')
                                        @if($item['row'] == '1')
                                            <x-site.products.product-slider-single :data="$item" />
                                        @elseif($item['row'] == '2')
                                            <x-site.products.product_carousel :data="$item" />
                                        @else
                                            <x-site.products.product-slider-3row :data="$item" />
                                        @endif
                                    @else
                                        <x-site.products.product-grid  :data="$item" />
                                    @endif
                                @break
                                @case('articles')
                                    @if($item['type'] == 'slider')
                                        @if($item['row'] == '1')
                                            <x-site.articles.articles-slider-single :data="$item" />
                                        @elseif($item['row'] == '2')
                                            <x-site.articles.articles_carousel :data="$item" />
                                        @else
                                            <x-site.articles.articles-slider-3row :data="$item" />
                                        @endif
                                    @else
                                        <x-site.articles.articles-grid :data="$item" />
                                    @endif
                                @break
                                @case('categories')
                                    @if($item['type'] == 'slider')
                                        <x-site.categories.top_category_product :data="$item" />
                                    @else
                                        <x-site.categories.category-grid :data="$item" />
                                    @endif
                                @break
                                @case('banners')
                                    <x-site.banners.banner :data="$item" />
                                @break
                            @endswitch
                        @else
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!--hoem section four area end-->

    <!--shipping area start-->
    <x-site.shipping />
</div>
