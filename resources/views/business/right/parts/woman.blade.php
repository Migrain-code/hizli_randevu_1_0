<div
    class="tab-pane fade @if($business->type_id == 1 || $business->type_id == 3) show active @endif"
    id="pills-1"
    role="tabpanel"
    aria-labelledby="pills-home-tab"
    tabindex="0"
>
    <div class="accordion accordion-flush" id="accordionFlushExampleWoman">
        @if(count($womanServices["featured"]) > 0)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse-woman-featured"
                        aria-expanded="false"
                        aria-controls="flush-collapse-woman-featured"
                    >
                        Sık Kullanılan Hizmetler
                    </button>
                </h2>
                <div
                    id="flush-collapse-woman-featured"
                    class="accordion-collapse "
                    data-bs-parent="#accordionFlushExampleWoman"
                >
                    <div class="accordion-body">
                        <div class="accordionList">
                            @forelse($womanServices["featured"] as $service)
                                <div class="accordionListItem">
                                    <div class="row">
                                        <div
                                            class="col-xl-5 col-lg-6 d-flex align-items-center"
                                        >
                                            <span>{{$service["name"]}}</span>
                                        </div>
                                        <div
                                            class="col-xl-7 d-flex align-items-center justify-content-between justify-content-xl-end"
                                        >
                                            <span>{{$service["price"]}} TL</span>
                                            <a href="{{ route('step1.show', ['business' => $business->slug, 'request' => array('services' => array($service["id"]))])}}">Randevu Al</a>
                                        </div>
                                    </div>
                                </div>

                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @forelse($womanServices["services"] as $womanService)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse-woman-{{$loop->index}}"
                        aria-expanded="false"
                        aria-controls="flush-collapse-woman-{{$loop->index}}"
                    >
                        {{$womanService['name']}}
                    </button>
                </h2>
                <div
                    id="flush-collapse-woman-{{$loop->index}}"
                    class="accordion-collapse {{$loop->first && count($womanServices["featured"]) == 0 ? "" : "collapse"}}"
                    data-bs-parent="#accordionFlushExampleWoman"
                >
                    <div class="accordion-body">
                        <div class="accordionList">
                            @forelse($womanService["services"] as $service)
                                <div class="accordionListItem">
                                    <div class="row">
                                        <div
                                            class="col-xl-5 col-lg-6 d-flex align-items-center"
                                        >
                                            <span>{{$service["name"]}}</span>
                                        </div>
                                        <div
                                            class="col-xl-6 d-flex align-items-center justify-content-between justify-content-xl-end"
                                        >
                                            <span>{{$service["price"]}} TL</span>
                                            <a href="{{ route('step1.show', ['business' => $business->slug, 'request' => array('services' => array($service["id"]))])}}">Randevu Al</a>
                                        </div>
                                    </div>
                                </div>

                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>


        @empty
            <div class="alert alert-warning">Bu türde hizmet bulunamadı</div>
        @endforelse
    </div>
</div>
