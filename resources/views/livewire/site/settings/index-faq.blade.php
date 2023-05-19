<div>
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="text-dark font-weight-bold text-8">سوالات متداول</h1>
                    </div>

                    <div class="col-md-12 align-self-center order-1">
                        <x-site.breadcrumbs :data="$address" />
                    </div>
                </div>
            </div>
        </section>

        <div class="container py-4">

            <div class="row">
                <div class="col">
                    <div class="toggle toggle-primary" data-plugin-toggle>
                        @foreach($data['faq'] as $key => $item)
                            <section class="toggle {{$key == 0 ? 'active' : ''}} ">
                                <a class="toggle-title">
                                    {!! $item->value['question'] !!}
                                </a>
                                <div class="toggle-content">
                                    {!! $item->value['answer'] !!}
                                </div>
                            </section>
                        @endforeach
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>
