<div>
    <div class="slider-container rev_slider_wrapper" style="height: 530px;">
        <div id="revolutionSlider" class="slider rev_slider" data-version="5.4.8" data-plugin-revolution-slider data-plugin-options="{'delay': 9000, 'gridwidth': 1170, 'gridheight': 530, 'responsiveLevels': [4096,1200,992,500], 'navigation' : {'arrows': { 'enable': false }, 'bullets': {'enable': false, 'style': 'bullets-style-1 bullets-color-primary', 'h_align': 'center', 'v_align': 'bottom', 'space': 7, 'v_offset': 70, 'h_offset': 0}}}">
            <ul>
                <li data-transition="fade">
                    <img
                        src="{{asset($slider['sliderImage'])}}"
                        alt=""
                        data-bgposition="center center"
                        data-bgfit="cover"
                        data-bgrepeat="no-repeat"
                        class="rev-slidebg">

                    <div
                        class="tp-caption"
                        data-x="center"
                        data-hoffset="['-85','-85','-85','-130']"
                        data-y="center"
                        data-voffset="['-120','-120','-120','-180']"
                        data-start="1000"
                        data-transform_in="x:[-300%];opacity:0;s:500;"
                        data-transform_idle="opacity:0.8;s:500;"><img src="{{asset('assets/img/slides/slide-title-border-light.png')}}" alt=""></div>

                    <div
                        class="tp-caption text-color-dark font-weight-semibold"
                        data-x="center"
                        data-y="center"
                        data-voffset="['-122','-122','-122','-183']"
                        data-start="700"
                        data-fontsize="['22','22','22','40']"
                        data-lineheight="['40','40','40','74']"
                        data-transform_in="y:[-50%];opacity:0;s:500;">قالب پورتو</div>

                    <div
                        class="tp-caption"
                        data-x="center"
                        data-hoffset="['85','85','85','130']"
                        data-y="center"
                        data-voffset="['-120','-120','-120','-180']"
                        data-start="1000"
                        data-transform_in="x:[300%];opacity:0;s:500;"
                        data-transform_idle="opacity:0.8;s:500;"><img src="{{asset('assets/img/slides/slide-title-border-light.png')}}" alt=""></div>

                    <div
                        class="tp-caption font-weight-extra-bold text-color-dark secondary-font"
                        data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:1.5;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                        data-x="center"
                        data-y="center"
                        data-voffset="['-55','-55','-55','-85']"
                        data-fontsize="['50','50','50','70']"
                        data-lineheight="['55','55','55','95']">{{$slider['slider']}}</div>

                    <div
                        class="tp-caption font-weight-light text-color-dark"
                        data-frames='[{"from":"opacity:0;","speed":300,"to":"o:1;","delay":2000,"ease":"Power2.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                        data-x="center"
                        data-y="center"
                        data-voffset="['25','25','25','30']"
                        data-fontsize="['18','18','18','36']"
                        data-lineheight="['34','34','34','68']"
                        style="color: #b5b5b5;">{{$slider['subtitle']}}</div>

                    @if($slider['sliderLink'])
                    <a
                        class="tp-caption btn btn-outline-primary font-weight-bold"
                        href="{{$slider['sliderLink']}}"
                        data-frames='[{"delay":2000,"speed":2000,"frame":"0","from":"y:50%;opacity:0;","to":"y:0;o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                        data-x="center"
                        data-hoffset="0"
                        data-y="center"
                        data-voffset="['105','105','105','150']"
                        data-paddingtop="['15','15','15','30']"
                        data-paddingbottom="['15','15','15','30']"
                        data-paddingleft="['40','40','40','57']"
                        data-paddingright="['40','40','40','57']"
                        data-fontsize="['13','13','13','25']"
                        data-lineheight="['20','20','20','25']">ادامه <i class="fas fa-arrow-left ml-1"></i></a>

                    @endif

                </li>
            </ul>
        </div>
    </div>
    <div class="home-intro home-intro-quaternary" id="home-intro">
        <div class="container">

            <div class="row text-center">
                <div class="col">
                    <p class="mb-n1">
                        سریع ترین راه برای گسترش کسب و کار شما با شرکت پیشرو در تکنولوژی
                        <span class="sub-text">ویژگی ها و گزینه های ما را بررسی کنید.</span>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
