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
                    $servicePrice = null;
                    $isCalculate = [];
                @endphp
                @forelse($selectedServices as $index => $service)
                    @if(isset(request()['request']['personels']))
                        @php
                            if ($service->price_type_id == 1){
                                $isCalculate[] = 1;
                            } else{
                                $isCalculate[] = 0;
                            }
                            $personelPrice = $service->getPersonelPrice(request()['request']['personels'][$index]);
                            if ($personelPrice){
                                $servicePrice = $personelPrice->price;
                            } else{
                                $servicePrice = $service->getPrice();
                            }
                        @endphp
                    @endif


                    @if(isset($personelPrice) && isset(request()['request']['selection_room_id']))
                        @php
                            $toplam= $service->getPrice(request()['request']['selection_room_id'], $personelPrice->price);
                        @endphp
                    @elseif(isset($personelPrice))
                        @php
                            $toplam= $service->getPrice(null, $personelPrice->price);
                        @endphp

                    @else
                        @if(isset(request()['request']['selection_room_id']))
                                @if(is_numeric($service->getPrice(request()['request']['selection_room_id'])))
                                    @php($toplam+= $service->getPrice(request()['request']['selection_room_id']))
                                @else
                                    @php( $toplam = "Hesaplanacak";)
                                @endif

                        @else
                            @if(is_numeric($service->getPrice()))
                                    @php($toplam+= $service->getPrice())
                            @endif

                        @endif
                    @endif



                    <div class="summaryServicesItem">
                        @if(isset(request()['request']['selection_room_id']))

                            @if($servicePrice == null)
                                @if(!isset(request()['request']["personels"]))
                                    <span>{{$service->subCategory->name . "(" . $service->gender->name ." ) "}}</span>
                                @else
                                    <span>{{$service->subCategory->name . "(" . $service->gender->name ." ) ".  $service->getPrice(request()['request']['selection_room_id'], null). " TL"}}</span>
                                @endif
                            @else
                                @if(!isset(request()['request']["personels"]))
                                   <span>{{$service->subCategory->name . "(" . $service->gender->name ." ) "}}</span>
                                @else

                                    <span>{{$service->subCategory->name . "(" . $service->gender->name ." ) ".  $service->getPrice(request()['request']['selection_room_id'], $servicePrice) . " TL"}}</span>

                                @endif
                            @endif
                        @else

                            @if($servicePrice == null)
                                @if(!isset(request()['request']["personels"]))
                                    <span>{{$service->subCategory->name . "(" . $service->gender->name ." ) "}}</span>
                                @else
                                    <span>{{$service->subCategory->name . "(" . $service->gender->name ." ) ".  $service->getPrice(null, $personelPrice->price) . " TL"}}</span>
                                @endif
                            @else
                                @if(!isset(request()['request']["personels"]))
                                    <span>{{$service->subCategory->name . "(" . $service->gender->name ." ) "}}</span>
                                @else
                                    <span>{{$service->subCategory->name . "(" . $service->gender->name ." ) ".  $service->getPrice(null, $personelPrice?->price) . " TL"}}</span>
                                @endif
                            @endif
                        @endif
                    </div>

                @empty
                    <div class="alert alert-waring"><u>Lütfen Hizmet Seçiniz</u></div>
                @endforelse

            </div>
        </div>
        @if(isset(request()['request']["personels"]))
            <div class="summaryItem">
                <div
                    class="d-flex align-items-center justify-content-between"
                >

                    <span>Toplam</span>
                    @if(in_array(1, $isCalculate))
                        <span style="font-size: 15px"><b>Fiyat İşletmede Hesaplanacak</b></span>
                    @else
                        <span id="totalPrice"><b>{{$toplam}}</b> TL</span>
                    @endif

                </div>
            </div>
        @endif


    </div>
</div>
