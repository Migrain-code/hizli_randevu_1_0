@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>
        #myModal{
            max-width: 100%;
        }
        #myModal > .modal-dialog {
            border-radius: 15px;
            max-width: 100%;
            margin-right: 5px !important;
            margin-left: 5px !important;
            margin-top: 5px !important;
        }
        #myModal > .modal-fullscreen .modal-footer, .modal-fullscreen .modal-header {
            border: none;
        }

        #myModal > .modal-fullscreen .modal-content {
            height: 100%;
            border: 0;
            border-radius: 23px;
        }
        @media (min-width: 576px)
        {
            #myModal > .modal-dialog {
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
        .servicesLists .servicesItem.checkServicesItem input + .checkServicesItemContent {
            display: block;
            padding: 25px;
            background: rgba(67, 80, 110, 0.03);
            border-radius: 15px;
            margin-bottom: 30px;
        }
    </style>
    <style>
        #loader {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        /* Customize the loader appearance (e.g., use a spinner or any other loading animation) */
        #loader::before {
            content: "";
            width: 50px;
            height: 50px;
            border: 5px solid #ccc;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Doğrulama Kodunu Giriniz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align: center;">
                    <div class="mb-3">
                        <label id="appointmentCounter" style="
                            color: #5c636a;
                            font-weight: 700;
                            font-size: 2.2rem;
                            ">30</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="verificationCode" id="verificationCode" placeholder="Örn:(462584)">
                        <label for="name">Doğrulama Kodunuz</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal Et</button>
                    <button type="button" class="btn btn-primary" onclick="verifyPhoneCode()">Gönder</button>
                </div>
            </div>
        </div>
    </div>
    @php
        $serviceArray = [];
        foreach ($selectedServices as $service){
            $serviceArray[] = $service->id;
        }

    @endphp
@endsection

@section('scripts')
    @include('appointment.component.edit-service')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $("#verificationCode").inputmask({"mask": "999999"});
    </script>
    <script>
        $(document).on('change','.active-time',function() {
            scrollToElement('userInfoContainer');
            $('#times').html('');

            $('.active-time:checked').each(function() {
                var selectedValue = $(this).val();
                var selectedClock = $(this).data('clock');
                $('#selectedClockContainer').text(selectedClock);
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

        document.addEventListener("DOMContentLoaded", function() {
            clickedDate('{{now()->format('d.m.Y')}}');
        });

        var newToken = '{{csrf_token()}}';
        function clickedDate(clickedTime){
            scrollToElement('clockSelectContainer');
            if (clickedTime instanceof Date && !isNaN(clickedTime)) {
                clickedTime = formatDate(clickedTime);

            }
            $('#selectedTime').text(clickedTime);
            var appointmentInput = document.querySelector('input[name="appointment_date"]');
            appointmentInput.value= clickedTime;

            var apiUrl = '{{route('appointment.clocks')}}';

            var postData = {
                business_id: businessId,
                date: clickedTime,
                personals: personels,
                services: selectedServices,
                _token:newToken
            };

            $.ajax({
                url: apiUrl,
                method: "POST",
                data: JSON.stringify(postData),
                contentType: "application/json",
                success: function (data) {
                    var container = document.getElementById("timeContainer");
                    container.innerHTML = ""; // Önceki içeriği temizle
                    if (data.status != "error") {
                        // API'den gelen verileri işleyin ve HTML öğelerini oluşturun

                        data.forEach(function (clock) {
                            var newHtml = `
                        <label class="timePickerRadio">
                            <input
                                class="form-check-input ${clock.durum ? 'active-time' : ''}"
                                ${clock.durum ? '' : 'disabled'}
                                type="radio"
                                name="appointment_time"
                                data-clock="${clock["saat"]}"
                                value="${clock["value"]}"
                            />
                            <span>${clock["saat"]}</span>
                        </label>
                    `;
                            container.innerHTML += newHtml; // HTML içeriğini güncelle

                        });
                    } else {
                        Swal.fire({
                            title: "<strong>Uyarı</u></strong>",
                            icon: "info",
                            html: `
                                    <b>${data.message}</b>
                                  `,
                            showCloseButton: true,
                            showCancelButton: true,
                            focusConfirm: false,
                            confirmButtonText: `
                                            <i class="fa fa-thumbs-up"></i> Tarihi Değiştir!
                                          `,
                            confirmButtonAriaLabel: "Thumbs up, great!",
                            cancelButtonText: `
                                        <i class="fa fa-thumbs-down"></i> Randevuyu İptal Et
                                      `,
                            cancelButtonAriaLabel: "Thumbs down"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (clickedTime instanceof Date && !isNaN(clickedTime)) {
                                    clickedTime = formatDate(clickedTime);

                                }
                                var parts = clickedTime.split('.'); // Tarihi parçalara ayır

                                // parts[2] -> yıl, parts[1] -> ay, parts[0] -> gün
                                var formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                                var originalDate = new Date(formattedDate); // Örnek tarih
                                var nextDay = new Date(originalDate);
                                nextDay.setDate(originalDate.getDate() + 1);

                                clickedDate(nextDay);

                                let newClickedTime = formatDate(nextDay);

                                var targetInput = document.querySelector('input[data-clock="' + newClickedTime + '"]');
                                console.log('targetInput', newClickedTime);
                                targetInput.checked = true;
                            } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                                window.location.href = "{{route('business.detail', $business->slug)}}"
                            }
                        });
                        var newHtml = `
                        <div class="alert alert-danger">${data.message}</div>
                    `;
                        container.innerHTML += newHtml;
                    }
                },
            });
        }
        function formatDate(date) {
            var day = date.getDate();
            var month = date.getMonth() + 1; // Months are zero-based
            var year = date.getFullYear();

            var formattedDay = day < 10 ? '0' + day : day;
            var formattedMonth = month < 10 ? '0' + month : month;

            // Özel format: dd/MM/yyyy
            return `${formattedDay}.${formattedMonth}.${year}`;
        }
        function showLoader() {
            // Display a loading spinner or any other loading indicator
            document.getElementById("loader").style.display = "block";
        }

        function hideLoader() {
            // Hide the loading spinner or loading indicator
            document.getElementById("loader").style.display = "none";
        }
        function phoneControl(){
            let phoneNumber = document.getElementById('phone').value;
            let userName = document.getElementById('name').value;

            if (userName.trim() === "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Lütfen Adınızı Giriniz",
                });
                return;
            }



            $.ajax({
               url: "{{route('appointment.phoneControl')}}",
               dataType: "JSON",
               method: "GET",
               data: {
                   name: userName,
                   phone: phoneNumber,
               },
               success:function (response){
                   if(response.status == "success"){
                       Swal.fire({
                           icon: "success",
                           title: "Doğrulama Kodunuz Gönderildi...",
                           text: response.message,
                       });

                       $('#staticBackdrop').modal('show');

                       var sayac = 60;
                       var interval = setInterval(function () {
                           document.getElementById('appointmentCounter').innerText = sayac;
                           sayac--;

                           if (sayac < 0) {
                               clearInterval(interval);
                               phoneControl();
                               //sayac=30;
                           }
                       }, 1000); // 1000 milisaniye = 1 saniye
                   }
               }
            });
        }
        function verifyPhoneCode(){
            let verifyCode = document.getElementById('verificationCode').value;
            let phoneNumber = document.getElementById('phone').value;

            $.ajax({
                url: "{{route('appointment.phoneVerify')}}",
                dataType: "JSON",
                method: "GET",
                data: {
                    verify_code: verifyCode,
                    phone: phoneNumber,
                },
                success: function (response) {
                    Swal.fire({
                        icon: response.status,
                        title: response.message,
                    });

                    if (response.status == "success") {
                        setTimeout(function (){
                            $('#step-4-form').submit()
                        }, 2000)
                    }
                }
            });
        }

        function scrollToElement(className) {
            var element = document.querySelector('.' + className);
            if (element) {
                var topPos = element.getBoundingClientRect().top + window.pageYOffset;
                window.scrollTo({
                    top: topPos,
                    behavior: 'smooth' // Düzgün bir kaydırma efekti için 'smooth' kullanılır
                });
            }
        }
    </script>


@endsection

