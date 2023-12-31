<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.60/inputmask/jquery.inputmask.js"></script>
<script>
    $(".phone").inputmask({"mask": "(999)-999-9999"});
    function toggleHeart(element) {
        var heartIcon = element.getElementsByTagName('i')[0];
        var businessId = element.dataset.business;

        if (heartIcon.classList.contains('fa-heart-o')) {
            heartIcon.classList.remove('fa-heart-o');
            heartIcon.classList.add('fa-heart');
        } else {
            heartIcon.classList.remove('fa-heart');
            heartIcon.classList.add('fa-heart-o');
        }
        $.ajax({
            url: '{{route('customer.favorite.add')}}',
            type: 'POST',
            data: {
                '_token': '{{csrf_token()}}',
                'id': businessId
            },
            dataType:'json',
            success:function (res){
                Swal.fire({
                    position: 'center',
                    icon: res.status,
                    title: res.message,
                    showConfirmButton: false,
                    timer: 3000,
                    background: '#fff',
                    customClass: {
                        title: 'text-primary fs-6',
                        content: 'text-dark',
                        popup: 'bg-light',

                    },
                    timerProgressBar: true,
                    width: '25rem',
                    height: '2.5rem',
                    fontsize:'15px'
                })
            }
        });

    }
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
@if($errors->any())
    <script>
        var errors = [];
        @foreach ($errors->all() as $error)
        errors.push("{{ $error }}");
        @endforeach

        Swal.fire({
            title: 'Eksik Alanlar Var',
            icon: 'error',
            html: errors.join("<br>"),
            confirmButtonText: "Tamam"
        });
    </script>
@endif
@yield('scripts')
