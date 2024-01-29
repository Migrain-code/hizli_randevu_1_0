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
        .swiper-buttons {
            position: absolute;
            top: 2%;
            transform: translateY(-50%);
            right: 12%;
            z-index: 10;
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-family: swiper-icons;
            font-size: 15px;
            text-transform: none!important;
            letter-spacing: 0;
            font-variant: inherit;
            line-height: 1;
        }
        .swiper-button-next, .swiper-button-prev {
            position: absolute;
            top: 25px;
            width: 24px;
            height: 24px;
            margin-top: -15px;
            z-index: 10;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background-color: #f22969;
            padding: 20px;
            border-radius: 50%;
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


        document.addEventListener("DOMContentLoaded", function () {
            var mySwiper = new Swiper('.mySwiper', {
                slidesPerView: 1, // Sadece bir slide görünür
                spaceBetween: 10, // Slide'lar arasındaki boşluk
                loop: false, // Sonsuz döngü
                navigation: {
                    nextEl: '.swiper-button-next', // nextEl'i özel div içindeki düğme ile ilişkilendir
                    prevEl: '.swiper-button-prev'  // prevEl'i özel div içindeki düğme ile ilişkilendir
                }
            });
        });
    </script>
    <script>
        var appUrl = "{{env('APP_URL')}}";
        var offDay = "{{$business->off_day}}";
        var businessId = "{{$business->id}}";
        var personels = {!! isset(request()->query()['request']['personels']) ? json_encode(request()->query()['request']['personels']) : "" !!};

        function clickedDate(clickedTime){
            var appointmentInput = document.querySelector('input[name="appointment_date"]');
            appointmentInput.value= clickedTime;

            var apiUrl = "/api/appointment/clock/get";

            var postData = {
                business_id: businessId,
                date: clickedTime,
                personals: personels,
            };

            fetch(apiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(postData)
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error("API isteği başarısız!");
                    }
                    return response.json();
                })
                .then(function (data) {
                    // API'den gelen verileri işleyin ve HTML öğelerini oluşturun
                    var swiperSlides = document.querySelectorAll('.swiper-wrapper .swiper-slide');

                    swiperSlides.forEach(function(slide) {
                        slide.remove();
                    });
                    var personelTimesDiv = document.getElementById('personelTimes');
                    personelTimesDiv.innerHTML="";
                    data.personel_clocks.forEach(function (row) {
                        var newTimeInput = document.createElement('input');
                        newTimeInput.type = "hidden";
                        newTimeInput.checked = "true";
                        newTimeInput.id =`appointment_time${row.personel.id}`;
                        newTimeInput.name ="times[]";

                        personelTimesDiv.appendChild(newTimeInput);
                        var docTimesHtml = "";
                        row.clocks.forEach(function (clock){
                            if (clock.durum == false){
                                var newHtml = `

                            <div class="timePickerRadio">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="appointment_time[${row.personel.id}]"
                                    value="${clock.saat}"
                                    id="flexRadioDefault1"

                                />
                                <span>${clock.saat}</span>
                            </div>
                        `;

                                docTimesHtml += newHtml;
                            }
                            else {
                                var newHtml = `
                            <label class="timePickerRadio">
                                <input
                                    class="form-check-input active-time"
                                    type="radio"
                                    name="appointment_time[${row.personel.id}]"
                                    value="${clock.saat}"

                                />
                                <span>${clock.saat}</span>
                            </label>
                        `;
                                docTimesHtml += newHtml;
                            }
                        })

                        var newSlide = document.createElement('div');
                        newSlide.classList.add('swiper-slide');
                        var newTimePicker = document.createElement('div');
                        newTimePicker.classList.add('timePickers');
                        newTimePicker.innerHTML = docTimesHtml;
                        newSlide.innerHTML =`<div class="w-100 text-center" style="padding: 15px"><h4>${row.personel.name} İçin Saat Seçin</h4></div>` + newTimePicker.outerHTML;

                        var swiperWrapper = document.querySelector('.swiper-wrapper');
                        swiperWrapper.appendChild(newSlide);
                    });
                })
                .catch(function (error) {
                    console.error("API hatası:", error);
                });
        }
    </script>

    <script src="/assets/js/appointment.js"></script>
@endsection

