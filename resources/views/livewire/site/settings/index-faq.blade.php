<div>
    <x-site.breadcrumbs :data="$address" />
    <div class="faq_content_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="faq_content_wrapper">
                        <h2>سوالات متداول</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id="accordion" class="card__accordion">
                        @foreach($data['faq'] as $key => $item)
                            <div class="card card_dipult">
                                <div class="card-header card_accor" id="heading{{$key}}">
                                    <button class="btn btn-link {{ $key == 0 ? '' : 'collapsed' }} " data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                        {!! $item->value['question'] !!}
                                        <i class="fa fa-plus"></i>
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <div id="collapse{{$key}}" class="collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="heading{{$key}}" data-parent="#accordion">
                                    <div class="card-body">
                                        {!! $item->value['answer'] !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
