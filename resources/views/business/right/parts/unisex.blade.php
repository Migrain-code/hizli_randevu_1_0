<div
    class="tab-pane fade "
    id="pills-3"
    role="tabpanel"
    aria-labelledby="pills-profile-tab"
    tabindex="0"
>
    <div class="accordion accordion-flush" id="accordionFlushExampleUnisex">
        @forelse($unisexServices["services"] as $unisexService)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse-unisex-{{$loop->index}}"
                        aria-expanded="false"
                        aria-controls="flush-collapse-unisex-{{$loop->index}}"
                    >
                        {{$unisexService["name"]}}
                    </button>
                </h2>
                <div
                    id="flush-collapse-unisex-{{$loop->index}}"
                    class="accordion-collapse {{$loop->first ? "" : "collapse"}}"
                    data-bs-parent="#accordionFlushExampleUnisex"
                >
                    <div class="accordion-body">
                        <div class="accordionList">
                            @forelse($unisexService["services"] as $service)
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
