<!-- Service Modal -->
<div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <div class="modal-body">
                <button
                    class="btn-close"
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                    style="
                width: 24px;
                margin-right: 0px;
                height: 24px;
                border-radius: 50%;
                padding: 5px;
                background: #d6d6d6;
                position: absolute;
                right: 40px;
                top: 30px;
                z-index: 1500;
              "
                >
                    <i class="fa fa-times"></i>
                </button>

                <section id="pageContent">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="select-service-form" method="get" action="{{route('step1.store')}}">
                                    <div class="pageTab mt-5 servicesTab" id="servicesTab">
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

                                        @endif
                                    </ul>

                                    <div class="tab-content" id="pills-tabContent">
                                        <div
                                            class="tab-pane fade @if($business->type_id == 1 || $business->type_id == 3) show active @endif"
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
                                                                                <div class="col-xl-5 col-lg-6 d-flex align-items-center">
                                                                                    <span>{{$service["name"]}}</span>
                                                                                </div>
                                                                                <div class="col-xl-6 d-flex align-items-center justify-content-between justify-content-xl-end">
                                                                                    <span>{{$service["price"]}} TL</span>

                                                                                    <fieldset class="checkbox-group">
                                                                                        <div class="checkbox">
                                                                                            <label class="checkbox-wrapper">
                                                                                                <input type="checkbox" class="checkbox-input" value="{{$service["id"]}}" @checked(in_array($service["id"], $serviceIds)) name="services[]" onchange="toggleLabel(this)"/>
                                                                                                <span class="checkbox-tile">
                                                                                                    <span class="checkbox-label" style="padding-right: 13px">@if(in_array($service["id"], $serviceIds)) Çıkar @else Ekle @endif</span>
                                                                                                </span>
                                                                                            </label>
                                                                                        </div>
                                                                                    </fieldset>
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
                                            class="tab-pane fade @if($business->type_id == 2) show active @endif"
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
                                                                                    <fieldset class="checkbox-group">
                                                                                        <div class="checkbox">
                                                                                            <label class="checkbox-wrapper">
                                                                                                <input type="checkbox" class="checkbox-input" value="{{$service["id"]}}" @checked(in_array($service["id"], $serviceIds)) name="services[]" onchange="toggleLabel(this)"/>
                                                                                                <span class="checkbox-tile">
                                                                                                    <span class="checkbox-label" style="padding-right: 13px">@if(in_array($service["id"], $serviceIds)) Çıkar @else Ekle @endif</span>
                                                                                                </span>
                                                                                            </label>
                                                                                        </div>
                                                                                    </fieldset>
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
                                                                                    <fieldset class="checkbox-group">
                                                                                        <div class="checkbox">
                                                                                            <label class="checkbox-wrapper">
                                                                                                <input type="checkbox" class="checkbox-input" value="{{$service["id"]}}" @checked(in_array($service["id"], $serviceIds)) name="services[]" onchange="toggleLabel(this)"/>
                                                                                                <span class="checkbox-tile">
                                                                                                    <span class="checkbox-label" style="padding-right: 13px">@if(in_array($service["id"], $serviceIds)) Çıkar @else Ekle @endif</span>
                                                                                                </span>
                                                                                            </label>
                                                                                        </div>
                                                                                    </fieldset>
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
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn-pink"
                    onclick="$('#select-service-form').submit()"
                    style="border: none"
                >
                    Kaydet
                </button>
            </div>
        </div>
    </div>
</div>
