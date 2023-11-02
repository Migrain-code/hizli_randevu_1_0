<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.60/inputmask/jquery.inputmask.js"></script>
<script>
    $(".phone").inputmask({"mask": "(999)-999-9999"});
</script>
@if(session('response'))
    <script>
        Swal.fire({
            title: '{{session('response.message')}}',
            icon: '{{session('response.status') == "danger" ? "error" : session('response.status')}}',
            confirmButtonText: "Tamam"
        });
    </script>
@endif
@yield('scripts')
