@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>
        .modal{
            max-width: 100%;
        }
        .modal-dialog {
            border-radius: 15px;
            max-width: 100%;
            margin-right: 5px !important;
            margin-left: 5px !important;
            margin-top: 5px !important;
        }
        .modal-fullscreen .modal-footer, .modal-fullscreen .modal-header {
            border: none;
        }
        .modal-fullscreen .modal-content {
            height: 100%;
            border: 0;
            border-radius: 23px;
        }
        @media (min-width: 576px)
        {
            .modal-dialog {
                margin-right: 5px !important;
                margin-left: 5px !important;
                margin-top: 5px !important;
            }
        }
        .accordion-button:not(.collapsed) {
            color: #f22969;
            border: 1px solid #f22969;
            background-color: #ffffff;
            box-shadow: inset 0 calc(-1 * var(--bs-accordion-border-width)) 0 #f22969;
        }
        .accordion-flush .accordion-item .accordion-button, .accordion-flush .accordion-item .accordion-button.collapsed {
            border-radius: 23px !important;
        }

        .timePickers .timePickerRadio input:disabled + span:hover {
            background: rgba(242, 41, 105, 0.1);
            color: #f22969;
            border: 1px solid #f22969;
        }
    </style>

@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="my-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                                <li class="breadcrumb-item"><a href="#">Kuaförler</a></li>
                                <li class="breadcrumb-item"><a href="#">{{$business->name}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Hizmet Seç
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
                        <div class="row mb-5">
                            <div class="col-lg-7">
                                @include('appointment.component.service')
                                @include('appointment.component.personel')
                                @include('appointment.component.date')
                                @include('appointment.component.clock')
                                @include('appointment.component.info')
                            </div>
                            <div class="col-lg-5">
                                @include('appointment.component.summary')
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </article>
    @php
        $serviceArray = [];
        foreach ($selectedServices as $service){
            $serviceArray[] = $service->id;
        }

    @endphp
@endsection

@section('scripts')
    @include('appointment.component.edit-service')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script>
        $(document).on('change','.active-time',function() {
            console.log('sa')
            $('#times').html('');

            $('.active-time:checked').each(function() {
                var selectedValue = $(this).val();
                var name = $(this).attr('name');

                $('#times').append('<input type="hidden" name="' + name + '" value="' + selectedValue + '">');
            });
        });

    </script>
    <script>
        var appUrl = "{{env('APP_URL')}}";
        var offDay = "{{$business->off_day}}";
        var businessId = "{{$business->id}}";
        var selectedServices = @json($serviceArray);
        var personels = {!! isset(request()->query()['request']['personels']) ? json_encode(request()->query()['request']['personels']) : "" !!};


        function clickedDate(clickedTime){
            var appointmentInput = document.querySelector('input[name="appointment_date"]');
            appointmentInput.value= clickedTime;

            var apiUrl = appUrl + "/api/appointment/clock/get-2";

            var postData = {
                business_id: businessId,
                date: clickedTime,
                personals: personels,
                services: selectedServices
            };

            $.ajax({
                url: apiUrl,
                method: "POST",
                data: JSON.stringify(postData),
                contentType: "application/json",
                success: function (data) {
                    console.log(data);
                    // API'den gelen verileri işleyin ve HTML öğelerini oluşturun
                    var container = document.getElementById("timeContainer");
                    container.innerHTML = ""; // Önceki içeriği temizle

                    data.forEach(function (clock) {
                        var newHtml = `
                        <label class="timePickerRadio">
                            <input
                                class="form-check-input ${clock.durum ? 'active-time' : ''}"
                                ${clock.durum ? '' : 'disabled'}
                                type="radio"
                                name="appointment_time[]"
                                value="${clock["saat"]}"
                            />
                            <span>${clock["saat"]}</span>
                        </label>
                    `;
                        container.innerHTML += newHtml; // HTML içeriğini güncelle
                    });
                },
            });
        }
    </script>

    <script src="/assets/js/appointment.js"></script>
@endsection

