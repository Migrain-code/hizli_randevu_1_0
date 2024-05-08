<div class="pageTab mt-5 salloonsTab" id="servicesTab">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            @if($business->type_id == 1)
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active"
                    id="pills-1-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-1"
                    type="button"
                    role="tab"
                    aria-controls="pills-1"
                    aria-selected="true"
                >
                    Kadın
                </button>
            </li>
           @endif
           @if($business->type_id == 2)
                <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="pills-2-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#pills-2"
                            type="button"
                            role="tab"
                            aria-controls="pills-2"
                            aria-selected="false"
                        >
                            Erkek
                        </button>
                    </li>
           @endif
           @if($business->type_id == 3)
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="pills-1-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#pills-1"
                            type="button"
                            role="tab"
                            aria-controls="pills-1"
                            aria-selected="true"
                        >
                            Kadın
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="pills-2-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#pills-2"
                            type="button"
                            role="tab"
                            aria-controls="pills-2"
                            aria-selected="false"
                        >
                            Erkek
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="pills-3-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#pills-3"
                            type="button"
                            role="tab"
                            aria-controls="pills-3"
                            aria-selected="true"
                        >
                            Unisex
                        </button>
                    </li>
           @endif




    </ul>

    <div class="tab-content" id="pills-tabContent">

        <div
            class="tab-pane fade show active"
            id="pills-1"
            role="tabpanel"
            aria-labelledby="pills-home-tab"
            tabindex="0"
        >
            <div class="accordion accordion-flush" id="accordionFlushExampleWoman">
                @forelse($womanServices as $womanService)
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
                                class="accordion-collapse {{$loop->first ? "" : "collapse"}}"
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

        <div
            class="tab-pane fade"
            id="pills-2"
            role="tabpanel"
            aria-labelledby="pills-profile-tab"
            tabindex="0"
        >
            <div class="accordion accordion-flush" id="accordionFlushExampleMan">
                @forelse($manServices as $manService)
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
                            class="accordion-collapse {{$loop->first ? "" : "collapse"}}"
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

        <div
            class="tab-pane fade "
            id="pills-3"
            role="tabpanel"
            aria-labelledby="pills-profile-tab"
            tabindex="0"
        >
            <div class="accordion accordion-flush" id="accordionFlushExampleUnisex">
                @forelse($unisexServices as $unisexService)
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

    </div>
</div>

<a href="javascript:;" class="btn-pink d-block text-center mt-5">
    Fiyat Al
</a>
