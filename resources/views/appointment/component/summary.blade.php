<div class="servicesBox">
    <div class="servicesBigTitle">Hizmet Özet</div>
    <div class="summaryContent">
        <div class="summaryItem">
            <div
                class="d-flex align-items-center justify-content-between"
            >
                <span>Salon</span>
                <span>{{$business->name}}</span>
            </div>
        </div>
        <div class="summaryItem">
            <div
                class="d-flex align-items-center justify-content-between"
            >
                <span>Personeller</span>
                <span>
                    @forelse($selectedPersonels as $personel)
                        <div style="
                            border-bottom: 1px dashed #848f9c70;
                            /* border: 1px solid red; */
                            padding: 5px;
                            font-weight: bold;
                            font-size: 18px;
                        ">{{$personel->name}} </div>

                    @empty
                        Personel Seçilmedi
                    @endforelse
                </span>
            </div>
        </div>
        <div class="summaryItem">
            <div
                class="d-flex align-items-center justify-content-between"
            >
                <span>Tarih</span>
                <span id="selectedTime">{{now()->format('d.m.Y')}}</span>
            </div>
        </div>
        <div class="summaryItem">
            <div
                class="d-flex align-items-center justify-content-between"
            >
                <span>Saat</span>
                <span id="selectedClockContainer">Saat Seçilmedi</span>
            </div>
        </div>
        <div class="summaryItem">
            <div
                class="d-flex align-items-center justify-content-between"
            >
                <span>Hizmetler</span>
            </div>
            <div class="summaryServices">


                @forelse($selectedServices as $service)
                    <div class="summaryServicesItem">
                        <span>{{$service->subCategory->name . "(" . $service->gender->name ." )"}}</span>
                    </div>

                @empty
                    <div class="alert alert-waring"><u>Lütfen Hizmet Seçiniz</u></div>
                @endforelse

            </div>
        </div>
    </div>
</div>
