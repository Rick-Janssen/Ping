@if (session()->has('message'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
             didOpen: (toast) => {
                 toast.addEventListener('mouseenter', Swal.stopTimer)
                 toast.addEventListener('mouseleave', Swal.resumeTimer)
             }
        })

        Toast.fire({
            icon: 'success',
            title: "{{ session('message') }}",
        })
    </script>
@endif
