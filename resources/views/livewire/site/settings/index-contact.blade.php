<div>
    <x-site.breadcrumbs :data="$address" />
    <div class="contact_map mt-60">
        <div class="contact_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="contact_message content">
                            <h3>تماس با ما</h3>
                            <p>
                                {{ $data['contactText'] }}
                            </p>
                            <ul>
                                <li><i class="fa fa-fw fa-map-marker"></i>{{$data['address']}}</li>
                                <li><i class="fa fa-fw fa-phone"></i><a href="tel:{{$data['tel']}}">{{$data['tel']}}</a></li>
                                <li><i class="fa fa-fw fa-envelope-o"></i> <a href="mailto:{{$data['email']}}">{{$data['email']}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key={{$data['googleMap']}}&language=fa"></script>
    <script src="https://www.google.com/jsapi"></script>
    <script src="{{asset('assets/js/map.js')}}"></script>
</div>
