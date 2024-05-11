@extends('layouts.master')
@section('title', 'Destek')
@section('styles')
    <style>
        .formBox1 {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 0;
        }
        .formBox1 .formBoxContent {
            background-color: #fff;
            width: 1000px;
            max-width: calc(100% - 40px);
            box-shadow: 50px 50px 130px rgba(67, 80, 110, 0.04);
            border-radius: 20px;
            overflow: hidden;
        }
        .formBox1 .formBoxContent .formBoxForm {
            width: 62%;
            padding: 0 60px;
        }
        .formBox1 .formBoxContent .formBoxForm .registerLabel {
            text-align: center;
            display: block;
            margin-bottom: 16px;
            font-style: normal;
            font-weight: 400;
            font-size: 15px;
            line-height: 22px;
            color: #43506e;
        }
        .btn-pink {
            display: inline-block;
            padding: 18px 32px;
            background: var(--pink);
            border-radius: 15px;
            font-weight: 500;
            font-size: 18px;
            line-height: 7px;
            color: var(--white);
            text-decoration: none;
        }
        .form-select {
            padding: 15px 30px;
        }
        .formBox1 .formBoxContent .formBoxForm {
            width: 100%;
            padding: 0 60px;
        }
        .bg-blue-300{
            background-color: aliceblue;
        }
        .customCheck {
            display: flex;
            align-items: center;
            margin-right: 5px;
        }
        .customCheck input{
            width: 16px;
            height: 16px;
            margin-right: 5px;
            color: #0000007d;
        }
        @media screen and (max-width: 768px) {
            .form-select {
                padding: 7px 20px;
                border: 1px solid rgba(67, 80, 110, 0.2) !important;
                border-radius: 15px;
                outline: none !important;
                box-shadow: none !important;
                font-weight: 400;
                font-size: 15px;
                line-height: 23px;
                color: rgba(67, 80, 110, 0.5);
            }
            .formBox1 .formBoxContent .formBoxForm {
                width: 100%;
                padding: 0 30px;
            }
        }
        .requiredBorder{
            border: 1px solid red !important;
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
                                <li class="breadcrumb-item active" aria-current="page">
                                    Sıkça Sorulan Sorular
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section id="pageContent">
            <div class="container">
                <div class="sss-page">
                    <div class="row text-center">
                            <div class="hero">
                                <h2>
                                    <span style="color: #43506e">Formu doldurun, {{$business->name. " ". $business->districts->name}} işletmesi size fiyatını iletsin</span> <br />
                                </h2>
                            </div>
                            <div class="subhead">
                                <p></p>
                            </div>
                    </div>
                    <div class="row">
                        <div class="formBox1">
                            <div class="formBoxContent d-md-flex align-items-center justify-content-center">
                                <form class="formBoxForm" id="fromRequest" method="post" action="{{route('business.takePriceQuestionForm', $business->slug)}}">
                                    @csrf
                                    <div class="mb-0 mt-2">
                                        <label class="registerLabel" style="margin-top: 20px">
                                            <h3>Talep Formu</h3>
                                        </label>
                                        <label class="registerLabel">Randevularınızı Akıllıca Planlayın, İşinizi Büyütün.</label>
                                    </div>
                                    <select
                                        type="text"
                                        name="request_form_service_id"
                                        class="form-select mb-3"
                                        id="floatingInput"
                                    >
                                        <!-- Form service id -->
                                        <option value="">Hangi Hizmet</option>
                                        @foreach($services as $service)
                                            <option value="{{$service->id}}">{{$service->service->subCategory->getName()}}</option>
                                        @endforeach
                                    </select>
                                    <div id="questionContainer"></div>
                                    <div class="row">
                                        <div class="col-6">
                                            <select
                                                type="text"
                                                name="goal_time_type"
                                                class="form-select mb-3"
                                                id="floatingInput"
                                            >
                                                <option value="">Ne Zaman</option>
                                                <option value="1">Belirli bir tarihte</option>
                                                <option value="2">Belirli bir süre içerisinde</option>
                                                <option value="3">Tarih belli değil</option>
                                            </select>
                                        </div>
                                        <div class="col-6" id="selectGoalTime">

                                        </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea
                                            type="text"
                                            name="note"
                                            class="form-control"
                                            id="floatingInput"
                                            placeholder="Cep Telefonu"
                                            rows="10"
                                            style="height: 118px;"
                                        ></textarea>
                                        <label for="floatingInput">Notlarınız</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input
                                            type="text"
                                            name="user_name"
                                            class="form-control"
                                            id="floatingInput"
                                            placeholder="Cep Telefonu"
                                            value=""
                                        />
                                        <label for="floatingInput">Adınız Soyadınız</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control phone"
                                            id="floatingInput"
                                            placeholder="Cep Telefonu"
                                            value=""
                                        />
                                        <label for="floatingInput">Cep Telefonu</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input
                                            type="text"
                                            name="email"
                                            class="form-control"
                                            id="floatingInput"
                                            placeholder="Cep Telefonu"
                                            value=""
                                        />
                                        <label for="floatingInput">E-posta Adresiniz</label>
                                    </div>
                                     <select
                                            type="text"
                                            name="contact_type"
                                            class="form-select mb-3"
                                            id="floatingInput"
                                        >   <option value="">İletişim Tercihi</option>
                                            <option value="1">İşletme(ler) numaramı görerek beni arayabilsin</option>
                                            <option value="2">İşletme(ler) numaramı göremesin, teklifler SMS ile iletilsin</option>
                                        </select>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <div class="customCheck">
                                                    <div class="customCheckInput">
                                                        <input type="checkbox" name="terms"/>
                                                        <span></span>
                                                    </div>
                                                    <span>  Hızlı Randevu kullanım ve gizlilik koşullarını okudum, onaylıyorum </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" style="border: 0px" id="submitButton" class="btn-pink w-100 p-4 text-center">
                                            Fiyat İste
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>

@endsection

@section('scripts')
    <script>
        var select1 = `<select
                                                type="text"
                                                name="goal_time"
                                                class="form-select mb-3"
                                                id="floatingInput"
                                            >
                                                <option value="">Zaman Seçiniz</option>
                                                <option value="1 Hafta İçerisinde">1 Hafta İçerisinde</option>
                                                <option value="2 Hafta İçerisinde">2 Hafta İçerisinde</option>
                                                <option value="3 Hafta İçerisinde">3 Hafta İçerisinde</option>
                                                <option value="1 Ay İçerisinde">1 Ay İçerisinde</option>
                                                <option value="2 Ay İçerisinde">2 Ay İçerisinde</option>
                                                <option value="3 Ay İçerisinde">3 Ay İçerisinde</option>
                                                <option value="6 Ay İçerisinde">6 Ay İçerisinde</option>
                                                <option value="1 Yıl İçerisinde">1 Yıl İçerisinde</option>
                                            </select>`;
        var select2 = `<div class="form-floating mb-3">
                                                <input
                                                    type="date"
                                                    name="goal_time"
                                                    class="form-control"
                                                    id="floatingInput"
                                                    placeholder=""
                                                    value=""
                                                />
                                                <label for="floatingInput">Tarih Seçiniz</label>
                                            </div>`;

        $('[name="goal_time_type"]').on('change', function (){
            var container = $('#selectGoalTime');
            container.empty();
            let val = $(this).val();
            if(val == 1){
                container.append(select2);
            } else if(val == 2){
                container.append(select1);
            }

        });
    </script>
    <script>
        $('[name="request_form_service_id"]').on('change', function (){
            let id = $(this).val();
            //$('#district_select').empty();
            $.ajax({
                url: '{{route('business.takePriceQuestion')}}',
                type: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'service_id': id
                },
                dataType:'json',
                success:function (response){
                    var seenIDs = {};
                    var questionContainer = document.getElementById("questionContainer");
                    questionContainer.innerHTML = "";
                    if(response.data.questions.length > 0){
                        response.data.questions.forEach(function(item) {
                            // Sorunun ID'sini al
                            var questionID = item.question.id;

                            // Eğer bu ID daha önce eklenmişse, döngüden çık
                            if (seenIDs[questionID]) return;

                            // Soruyu işaret et
                            seenIDs[questionID] = true;
                            // Sorunun adını al
                            var questionName = item.question.name;

                            // Sorunun id al

                            var questionId = item.question.id;
                            // Sorunun başlığını al

                            var questionTitle = item.question.title;
                            // Sorunun cevaplarını al
                            var answers = item.question.answers;

                            var services = item.services;
                            // Label oluştur
                            var label = document.createElement("label");
                            label.innerHTML = questionName;
                            // Eğer cevaplar boş ve hizmetler doluysa
                            if (answers.length === 0 && services.length > 0) {

                                // Yeni bir konteyner oluştur
                                var newContainer = document.createElement("div");
                                newContainer.classList.add("bg-blue-300", "p-3", 'my-2', 'rounded');

                                // Her bir hizmet için döngü yap
                                services.forEach(function(service) {
                                    // Div oluştur
                                    var div = document.createElement("div");
                                    div.classList.add("customCheck");
                                    // Checkbox oluştur
                                    var checkbox = document.createElement("input");
                                    checkbox.setAttribute("type", "checkbox");
                                    checkbox.setAttribute("name", "added_services[]");
                                    checkbox.setAttribute("value", service.name);
                                    checkbox.setAttribute("id", service.id);

                                    // Checkbox metnini oluştur
                                    var label = document.createElement("label");
                                    label.setAttribute("for", service.id);
                                    label.innerHTML = service.name;

                                    // Checkbox ve metni konteynere ekle
                                    newContainer.appendChild(checkbox);
                                    newContainer.appendChild(label);
                                    div.appendChild(checkbox);
                                    div.appendChild(label);

                                    newContainer.appendChild(div);
                                });

                                questionContainer.appendChild(label);
                                questionContainer.appendChild(newContainer);
                            } else{

                                // Select oluştur
                                var select = document.createElement("select");
                                select.setAttribute("name", `questions[${questionName}]`);
                                select.setAttribute("placeholder", questionTitle);
                                select.classList.add("form-select", "mb-3");

                                // İlk elemanı placeholder olarak ekle
                                var placeholderOption = document.createElement("option");
                                placeholderOption.text = questionTitle;
                                placeholderOption.disabled = true;
                                placeholderOption.selected = true;
                                select.appendChild(placeholderOption);

                                // Her cevap için option oluştur
                                answers.forEach(function(answer) {
                                    var option = document.createElement("option");
                                    option.value = answer.answer;
                                    option.text = answer.answer;
                                    select.appendChild(option);
                                });

                                // Label ve select'i questionContainer'a ekle
                                questionContainer.appendChild(label);
                                questionContainer.appendChild(select);
                            }



                        });
                    }
                }
            });
        });
    </script>

    <script>
        // Form elementini seç
        var form = document.getElementById("fromRequest");

        // Submit butonunu seç
        var submitButton = document.getElementById("submitButton");

        // Submit butonuna tıklama olayını ekle
        submitButton.addEventListener("click", function(event) {
            // Formun gönderilmesini engelle
            event.preventDefault();

            // Formdaki tüm inputları al
            var inputs = form.querySelectorAll("input, textarea, select");
            var allFieldsFilled = true;
            // Her bir input için döngü yap
            inputs.forEach(function(input) {
                // Checkboxları kontrol et
                if (input.type === "checkbox") {
                    return;
                }

                // Input boşsa
                if (input.value.trim() === "") {
                    // Kırmızı arka planı ayarla
                    input.classList.add('requiredBorder');
                    allFieldsFilled = false;
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Zorunlu Alanları Doldurmanız Gerekmektedir',
                        showConfirmButton: false,
                    })
                } else{
                    input.classList.remove('requiredBorder');
                }
                // Eğer tüm inputlar doluysa
                if (allFieldsFilled) {
                    // Formu gönder
                    document.getElementById("fromRequest").submit();
                }
            });
        });

    </script>
@endsection
