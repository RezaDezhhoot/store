@livewireScripts
<!-- Plugins JS -->
<script src="{{asset('assets/js/plugins.js')}}"></script>

<!-- Main JS -->
<script src="{{asset('assets/js/main.js')}}"></script>
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
