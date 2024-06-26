@extends('layouts.master')
@section('title', 'Randevu Detayı')
@section('meta_description', config('settings.meta_description'))
@section('styles')
    <style>
        @media screen and (max-width: 600px) {
            .btn-pink {
                height: 45px;
                font-size: 12px;
                padding: 10px 10px;
            }
        }
    </style>
@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="mt-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('customer.home')}}">Hesabım</a></li>

                                <li class="breadcrumb-item">
                                    <a href="{{route('customer.appointment.index')}}">Randevular</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Randevu Detayı
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <section id="pageContent">
                        <div class="d-flex align-items-start">
                            @include('customer.layouts.menu')
                            <div class="profileContent">
                                <div id="packageDetail">
                                    <div class="profileBox mb-3 packageSummary">
                                        <div class="profileTitle">
                                            Randevu Özeti
                                            @if($appointment->status == 0 || $appointment->status == 1)
                                                <button class="btn btn-pink cancelButton" style="float: right;margin-top: -15px;">İptal Et</button>
                                            @endif
                                        </div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>Randevu Kodu</span>
                                            <span>#{{$appointment->id}}</span>
                                        </div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>Randevu Tarihi</span>
                                            <span>{{$appointment->start_time}}</span>
                                        </div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>İşletme Adı</span>
                                            <span>
                                              <a target="_blank" href="{{route('business.detail', $appointment->business->slug)}}" class="text-primary">{{$appointment->business->name}}</a>
                                            </span>
                                        </div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>Durumu</span>
                                            <span>
                                                 {!! $appointment->status('html') !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @include('customer.appointment.services')
                                        @include('customer.appointment.comment')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </article>
@endsection
@section('scripts')
    <script>
        $('.starLabel').click(function() {
            $('.ratingStar').prop('checked', false);
            // 'for' özelliğine karşılık gelen radyo butonunu bul
            var radioValue = $(this).attr('for');
            // Radyo butonunun değerini al
            var isChecked = $('#' + radioValue).is(':checked');
        });
    </script>
    <script>
        $('.cancelButton').on('click', function (){
            Swal.fire({
                title: 'Bu Randevuyu İptal Etmek İstediğine Eminmisin',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Hayır, İptal Etme",
                confirmButtonText: "Evet, İptal Et!",
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '{{route('customer.appointment.cancel')}}',
                        type: "POST",
                        data: {
                            "_token": '{{csrf_token()}}',
                            'id': '{{$appointment->id}}',
                        },
                        dataType: "JSON",
                        success: function (res) {
                            if (res.status == "success"){
                                Swal.fire({
                                    title: "İşlem Başarılı",
                                    icon: res.status,
                                    text: res.message,
                                    confirmButtonText: 'Tamam'
                                })

                                setTimeout(function (){
                                    location.reload();
                                }, 700);
                            }
                            else {
                                Swal.fire({
                                    title: "Uyarı",
                                    icon: res.status,
                                    text: res.message,
                                    confirmButtonText: 'Tamam'
                                })
                            }

                        }
                    });
                }
            });
        });
    </script>
@endsection
