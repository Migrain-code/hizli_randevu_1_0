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

                @php
                    $toplam = 0;
                @endphp
                @forelse($selectedServices as $index => $service)
                    @if(isset(request()['request']['personels']))
                        @php
                            $servicePrice = 0;
                            $personelPrice = $service->getPersonelPrice(request()['request']['personels'][$index]);
                            if ($personelPrice){
                                $servicePrice = $personelPrice->price;
                            } else{
                                $servicePrice = $service->getPrice();
                            }
                        @endphp
                    @endif

                    @if(isset($personelPrice))
                        @php $toplam+= $servicePrice @endphp
                    @else
                        @if(isset(request()['request']['selection_room_id']))
                            @php($toplam+= $service->getPrice(request()['request']['selection_room_id']))
                        @else
                            @php($toplam+= $service->getPrice())
                        @endif
                    @endif


                    <div class="summaryServicesItem">
                        @if(isset(request()['request']['selection_room_id']))
                            <span>{{$service->subCategory->name . "(" . $service->gender->name ." ) ". $service->getPrice(request()['request']['selection_room_id']). " TL"}}</span>
                        @else
                            <span>{{$service->subCategory->name . "(" . $service->gender->name ." ) ". $servicePrice ?? $service->price. " TL"}}</span>
                        @endif
                    </div>

                @empty
                    <div class="alert alert-waring"><u>Lütfen Hizmet Seçiniz</u></div>
                @endforelse

            </div>
        </div>
        <div class="summaryItem">
            <div
                class="d-flex align-items-center justify-content-between"
            >
                <span>Toplam</span>
                <span id="totalPrice"><b>{{$toplam}}</b> TL</span>
            </div>
        </div>

    </div>
</div>
