@livewireScripts
<!-- Vendor -->
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.appear/jquery.appear.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.cookie/jquery.cookie.min.js')}}"></script>
<script src="{{asset('assets/vendor/popper/umd/popper.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/common/common.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.gmap/jquery.gmap.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.lazyload/jquery.lazyload.min.js')}}"></script>
<script src="{{asset('assets/vendor/isotope/jquery.isotope.min.js')}}"></script>
<script src="{{asset('assets/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/vendor/vide/jquery.vide.min.js')}}"></script>
<script src="{{asset('assets/vendor/vivus/vivus.min.js')}}"></script>

<script src="{{asset('assets/vendor/bootstrap-star-rating/js/star-rating.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-star-rating/js/locales/fa.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-star-rating/themes/krajee-fas/theme.min.js')}}"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{asset('assets/js/theme.js')}}"></script>
<script src="{{asset('assets/js/views/view.shop.js')}}"></script>
<!-- Current Page Vendor and Views -->
<script src="{{asset('assets/vendor/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
<script src="{{asset('assets/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>

<!-- Theme Custom -->
<script src="{{asset('assets/js/custom.js')}}"></script>

<!-- Theme Initialization Files -->
<script src="{{asset('assets/js/theme.init.js')}}"></script>




<script>
    Livewire.on('notify', data => {
        Swal.fire({
            position: 'top-end',
            icon: data.icon,
            title: data.title,
            showConfirmButton: false,
            timer: 4000,
            toast: true,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    })

</script>

@stack('scripts')
