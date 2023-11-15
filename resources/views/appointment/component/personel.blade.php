<div class="servicesBox">
    <div
        class="d-flex align-items-center justify-content-between"
    >
        <div class="stepsTitle d-flex align-items-start">
            <div class="step">2</div>
            <div class="text">
                <span>Personel Seçimi</span>

            </div>
        </div>
    </div>
    <div class="servicesBoxContent" style="padding-top: 10px;">
        <form method="get" action="{{route('step1.store', ['business' => $business->slug])}}">
            <input type="hidden" name="step" value="3">
            @foreach($ap_services as $service)
                <input type="hidden" name="services[]" value="{{$service->id}}">
                <p>{{$service->subCategory->name}} için personel seçiniz</p>
                <div
                    class="customSelect iconSelect servicesSelect customTomSelect"
                >
                    <select class="tomSelect" name="personels[]"  @if($loop->last) id="lastSelect" @endif required>
                        <option value="">{{$service->subCategory->name}} için Personel Seçiniz</option>
                        @forelse($service->personels as $service_personel)
                            <option value="{{$service_personel->personel->id}}" @selected(in_array($service_personel->personel->id, $selectedPersonelIds))>{{$service_personel->personel->name}}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            @endforeach
            <div class="d-flex justify-content-end">
                <button class="btn-pink" style="border: 0px; margin-top: 10px;" type="submit">Tarih/Saat Seç</button>
            </div>
        </form>

    </div>

</div>
