@if(isset(request()["request"]["step"]))
    <form method="post" id="step-4-form" action="{{route('appointment.create')}}">
     @csrf
    @foreach($ap_services as $service)
        <input type="hidden" name="services[]" value="{{$service->id}}">
    @endforeach
    @foreach($selectedPersonelIds as $personel_id)
        <input type="hidden" name="personels[]" value="{{$personel_id}}">
    @endforeach
        <input type="hidden" name="business_id" value="{{$business->id}}">

    <input type="hidden" name="appointment_date" id="appointment_date" value="">

    <div id="personelTimes">

    </div>
    <div class="servicesBox">
        @if(auth('customer')->check())
            <div class="alert alert-info"> Giriş Yaptığınız için kullanıcı bilgileriniz istenmeyecektir.</div>
        @else
            <div
                class="d-flex align-items-center justify-content-between"
            >
                <div class="stepsTitle d-flex align-items-start">
                    <div class="step">5</div>
                    <div class="text">
                        <span>Kişisel Bilgiler</span>
                        <p>Cep Telefonu Numaranız</p>
                    </div>
                </div>
            </div>
            <div class="servicesBoxContent">
                <div class="phoneInput mb-3 form-floating">
                    <input
                        type="text"
                        class="form-control phone"
                        id="floatingInput"
                        name="phone"
                        placeholder="Telefon"
                    />
                    <label for="floatingInput">Telefon</label>
                </div>
                <div class="form-floating mb-3">
                    <input
                        type="text"
                        class="form-control"
                        name="name"
                        id="floatingInput"
                        placeholder="Adınız Soyadınız"
                    />
                    <label for="floatingInput">Adınız Soyadınız</label>
                </div>


            </div>
        @endif
            <div
                class="buttonGroups d-flex align-items-center justify-content-end"
            >
                <a href="{{route('business.detail', $business->slug)}}" class="btn-gray">İptal</a>
                <a href="javascript:;" onclick="$('#step-4-form').submit()" class="btn-pink">Gönder</a>
            </div>
    </div>
    </form>
@endif
