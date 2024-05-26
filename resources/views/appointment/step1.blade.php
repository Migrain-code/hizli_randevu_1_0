@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>

        @media screen and (max-width: 1600px) {
            .servicesTab .nav .nav-item .nav-link {
                font-size: 25px;
                line-height: 0px;
            }
        }
        @media screen and (max-width: 768px) {
            .checkbox-group {
                margin-right: 15px;
                margin-top: -18px;
            }
            .servicesTab .nav .nav-item .nav-link {
                line-height: 0px;
                margin-bottom: -17px;
            }
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

        /* Gizli olan gerçek checkbox'u gizlemek için */
        .hidden-checkbox {
            display: none;
        }


        /* Gizli olan gerçek checkbox'u gizlemek için */
        .hidden-checkbox {
            display: none;
        }

        /* Görünür checkbox düğmesi stilini ayarlamak için */
        .custom-checkbox {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            border: 1px solid #43506e87;
            border-radius: 40px;
            cursor: pointer;
        }

        .hidden-checkbox:checked + .custom-checkbox {
            background-color: #2ecc71; /* Seçildiğinde arka plan rengi */
        }

        /* Seçili olmayan durum için yazı rengini değiştir */
        .custom-checkbox:not(:checked) {
            color: #000; /* Seçili olmayan durumda yazı rengi */
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            width: 10%;
            margin-left: auto;
            max-width: 600px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .checkbox-group > * {
            margin: 0.5rem 0.5rem;
        }

        .checkbox-group-legend {
            font-size: 1.5rem;
            font-weight: 700;
            color: #9c9c9c;
            text-align: center;
            line-height: 1.125;
            margin-bottom: 1.25rem;
        }

        .checkbox-input {
            clip: rect(0 0 0 0);
            -webkit-clip-path: inset(100%);
            clip-path: inset(100%);
            height: 1px;
            overflow: hidden;
            position: absolute;
            white-space: nowrap;
            width: 1px;
        }

        .checkbox-input:checked + .checkbox-tile {
            border-color: #f22969;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            color: #f22969;
        }

        .checkbox-input:checked + .checkbox-tile .checkbox-icon, .checkbox-input:checked + .checkbox-tile .checkbox-label {
            color: #f22969;
        }

        .checkbox-input:focus + .checkbox-tile {
            border-color: #f22969;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
        }

        .checkbox-input:focus + .checkbox-tile:before {
            transform: scale(1);
            opacity: 1;
        }

        .checkbox-tile {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 5.5rem;
            min-height: 3rem;
            border-radius: 1.5rem;
            border: 2px solid #b5bfd9;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            transition: 0.15s ease;
            cursor: pointer;
            position: relative;
        }

        .checkbox-input:checked + .checkbox-tile:before {
            transform: scale(1);
            opacity: 1;
            background-color: #f22969;
            border-color: #f22969;
        }

        .checkbox-tile:before {
            content: "";
            position: absolute;
            display: block;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #b5bfd9;
            background-color: #fff;
            border-radius: 50%;
            top: 0.75rem;
            right: 0.25rem;
            opacity: 0;
            transform: scale(0);
            transition: 0.25s ease;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='192' height='192' fill='%23FFFFFF' viewBox='0 0 256 256'%3E%3Crect width='256' height='256' fill='none'%3E%3C/rect%3E%3Cpolyline points='216 72.005 104 184 48 128.005' fill='none' stroke='%23FFFFFF' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'%3E%3C/polyline%3E%3C/svg%3E");
            background-size: 12px;
            background-repeat: no-repeat;
            background-position: 50% 50%;
        }

        .checkbox-tile:hover {
            border-color: #f22969;
        }

        #servicesTab .accordionList .accordionListItem {
            padding: 3px 0;
            border-top: 1px solid rgba(67, 80, 110, 0.2);
        }

        .checkbox-tile:hover:before {
            transform: scale(1);
            opacity: 1;
        }

        .checkbox-icon {
            transition: 0.375s ease;
            color: #494949;
        }

        .checkbox-icon svg {
            width: 3rem;
            height: 3rem;
        }

        .checkbox-label {
            color: #707070;
            transition: 0.375s ease;
            text-align: center;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
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
                                <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{route('search.businessCategorySearch', $business->category->getSlug())}}">{{$business->category->getName()}}</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{route('business.detail', $business->slug)}}">{{$business->name}}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Randevu Ekranı
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
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <input type="text" class="form-control" name="verificationCode" id="verificationCode"
                               placeholder="Örn:(462584)">
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
        $("#phone").inputmask({"mask": "999-999-9999"});
    </script>
    <script>
        function toggleLabel(checkbox) {
            var label = checkbox.parentElement.querySelector('.checkbox-label');
            if (checkbox.checked) {
                label.textContent = 'Çıkar';
            } else {
                label.textContent = 'Ekle';
            }
        }

    </script>
    <script>
        var roomID = "";
        $('#roomSelect').on('change', function () {
            roomID = $(this).val();
            $('[name="room_id"]').val(roomID);
        });
        $(document).on('change', '.active-time', function () {
            scrollToElement('userInfoContainer');
            $('#times').html('');

            $('.active-time:checked').each(function () {
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

        document.addEventListener("DOMContentLoaded", function () {
            clickedDate('{{now()}}');
        });

        var newToken = '{{csrf_token()}}';

        function clickedDate(clickedTime) {
            scrollToElement('clockSelectContainer');
            if (clickedTime instanceof Date && !isNaN(clickedTime)) {
                clickedTime = formatDate(clickedTime);

            }
            $('#selectedTime').text(clickedTime);
            var appointmentInput = document.querySelector('input[name="appointment_date"]');
            appointmentInput.value = clickedTime;

            var apiUrl = '{{route('appointment.clocks')}}';

            var postData = {
                business_id: businessId,
                date: clickedTime,
                room_id: roomID,
                personals: personels,
                services: selectedServices,
                _token: newToken
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
                                alert(formattedDate);
                                var originalDate = new Date(formattedDate); // Örnek tarih
                                var nextDay = new Date(originalDate);
                                nextDay.setDate(originalDate.getDate() + 1);

                                clickedDate(nextDay);

                                let newClickedTime = formatDate(nextDay);

                                var targetInput = document.querySelector('input[data-clock="' + newClickedTime + '"]');
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

        function phoneControl() {
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
                success: function (response) {
                    if (response.status == "success") {
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

        function verifyPhoneCode() {
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
                        setTimeout(function () {
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

