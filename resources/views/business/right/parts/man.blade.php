<div
    class="tab-pane fade @if($business->type_id == 2 || $business->type_id == 3) show active @endif"
    id="pills-2"
    role="tabpanel"
    aria-labelledby="pills-profile-tab"
    tabindex="0"
>
    <div class="accordion accordion-flush" id="accordionFlushExampleMan">
        @if(count($manServices["featured"]) > 0)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse-man-featured"
                        aria-expanded="false"
                        aria-controls="flush-collapse-man-featured"
                    >
                        Sık Kullanılan Hizmetler
                    </button>
                </h2>
                <div
                    id="flush-collapse-man-featured"
                    class="accordion-collapse "
                    data-bs-parent="#accordionFlushExampleMan"
                >
                    <div class="accordion-body">
                        <div class="accordionList">
                            @forelse($manServices["featured"] as $service)
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
                                            @if($service["price"] == 0)
                                                <span>Bilgi için arayın</span>
                                            @else
                                                <span>{{$service["price"]}} TL</span>
                                            @endif
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
        @forelse($manServices["services"] as $manService)
            @if(count($manService["services"]) > 0)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse-man-{{$loop->index}}"
                                aria-expanded="false"
                                aria-controls="flush-collapse-man-{{$loop->index}}"
                            >
                                {{$manService["name"]}}
                            </button>
                        </h2>
                        <div
                            id="flush-collapse-man-{{$loop->index}}"
                            class="accordion-collapse {{$loop->first && count($manServices["featured"]) == 0 ? "" : "collapse"}}"
                            data-bs-parent="#accordionFlushExampleMan"
                        >
                            <div class="accordion-body">
                                <div class="accordionList">
                                    @forelse($manService["services"] as $service)
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
                                                    @if($service["price"] == 0)
                                                        <span>Bilgi için arayın</span>
                                                    @else
                                                        <span>{{$service["price"]}} TL</span>
                                                    @endif
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

        @empty
            <div class="alert alert-warning">Bu türde hizmet bulunamadı</div>
        @endforelse
    </div>
</div>
