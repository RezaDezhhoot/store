<div>
    <x-site.breadcrumbs :data="$address" />
    <section class="about_section mt-60">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    {!! $data['aboutUs'] !!}
                </div>
            </div>
        </div>

    </section>
    <x-site.shipping />


        <div class="about_gallery_section">
            <div class="container">
                <div class="row">
                    @foreach(explode(',',$data['aboutUsImages']) as $item)
                        <div class="col-lg-3 col-md-3 col-6">
                            <article class="single_gallery_section">
                                <figure>
                                    <div class="gallery_thumb">
                                        <img src="{{ asset($item) }}" alt="">
                                    </div>
                                </figure>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

</div>
