@props(['data'])
<section class="slider_section slider_section_four mb-70 mt-30">
    <div class="container d-none d-sm-block">
        <div class="row">
            <div class="col-lg-9 offset-lg-3 col-ld-12">
                <div class="slider_area owl-carousel">
                    @foreach($data as $slider)
                        <a {{ !empty($slider['sliderLink']) ? 'href='.$slider['sliderLink'] : null  }}>
                            <div class="single_slider d-flex align-items-center" data-bgimg="{{ asset($slider['sliderImage']) }}">
                                <div class="slider_content slider_c_four">
                                    {!! $slider['slider'] !!}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

