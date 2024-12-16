@if($rooms->count() > 0)
     @if(isset(request()['request']['selection_room_id']))
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
                     @if(isset(request()['request']['selection_room_id']))
                         <input type="hidden" name="selection_room_id" value="{{request()['request']['selection_room_id']}}">
                     @endif
                     @php
                         $roomPersonelIds = [];
                           if(isset(request()['request']['selection_room_id'])){
                               $roomPersonelIds = request()['roomPersonelIds'];

                           }
                     @endphp
                     <input type="hidden" name="step" value="3">
                     @foreach($ap_services as $service)

                         <input type="hidden" name="services[]" value="{{$service->id}}">
                         <p>{{$service->subCategory->name}} için personel seçiniz</p>
                         <div
                             class="customSelect iconSelect servicesSelect customTomSelect"
                         >
                             <select class="tomSelect" name="personels[]"  @if($loop->last) id="lastSelect" @endif required>
                                 <option value="">Personel Seçiniz</option>

                                 @forelse($service->personels as $service_personel)
                                     @if(isset(request()['request']['selection_room_id']) && isset($roomPersonelIds))
                                         @if(in_array($service_personel->personel->id, $roomPersonelIds))
                                             <option value="{{$service_personel->personel->id}}" @selected(in_array($service_personel->personel->id, $selectedPersonelIds))>{{$service_personel->personel->name}}</option>
                                         @endif

                                     @else
                                         @if($rooms->count() > 0 && isset(request()['request']['selection_room_id']))
                                             <option value="{{$service_personel->personel->id}}" @selected(in_array($service_personel->personel->id, $selectedPersonelIds))>{{$service_personel->personel->name}}</option>
                                         @else
                                             <option value="">Oda seçimi Yapmadınız</option>
                                         @endif
                                     @endif
                                 @empty
                                     <option value="">Personel Bulunamadı</option>
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
     @endif
@else
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
                @if(isset(request()['request']['selection_room_id']))
                    <input type="hidden" name="selection_room_id" value="{{request()['request']['selection_room_id']}}">
                @endif
                @php
                    $roomPersonelIds = [];
                      if(isset(request()['request']['selection_room_id'])){
                          $roomPersonelIds = request()['roomPersonelIds'];

                      }
                @endphp
                <input type="hidden" name="step" value="3">
                @foreach($ap_services as $service)

                    <input type="hidden" name="services[]" value="{{$service->id}}">
                    <p>{{$service->subCategory->name}} için personel seçiniz</p>
                    <div
                        class="customSelect iconSelect servicesSelect customTomSelect"
                    >
                        <select class="tomSelect" name="personels[]"  @if($loop->last) id="lastSelect" @endif required>
                            <option value="">Personel Seçiniz</option>

                            @forelse($service->personels as $service_personel)

                                    @if(isset(request()['request']['selection_room_id']) && isset($roomPersonelIds))
                                        @if(in_array($service_personel->personel->id, $roomPersonelIds))
                                            @if($service_personel->personel->is_delete == 0)
                                                <option value="{{$service_personel->personel->id}}" @selected(in_array($service_personel->personel->id, $selectedPersonelIds))>{{$service_personel->personel->name}}</option>
                                            @endif
                                        @endif

                                    @else
                                        @if($service_personel->personel->is_delete == 0)
                                         <option value="{{$service_personel->personel->id}}" @selected(in_array($service_personel->personel->id, $selectedPersonelIds))>{{$service_personel->personel->name}}</option>
                                        @endif

                                    @endif


                            @empty
                                <option value="">Personel Bulunamadı</option>
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

@endif
