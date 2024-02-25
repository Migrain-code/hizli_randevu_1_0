<div class="modal modal-fullscreen fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="
                                                                                    width: 24px;
                                                                                    margin-right: 0px;
                                                                                    height: 24px;
                                                                                    border-radius: 50%;
                                                                                    padding: 5px;
                                                                                    background: #d6d6d6;
                                                                                    position: absolute;
                                                                                    right: 40px;
                                                                                    top: 30px;">
                    <i class="fa fa-times"></i>
                </button>
                <article id="page1">
                    <section id="breadcrumbs" class="">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#">Randevu Al</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                Hizmet Düzenle
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="pageContent">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="pageTab servicesTab">
                                        <form id="select-service-form" method="get" action="{{route('step1.store')}}">
                                            <ul
                                                class="nav nav-pills mb-5 justify-content-center justify-content-lg-start"
                                                id="pills-tab"
                                                role="tablist"
                                            >
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
                                                        Erkekler
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
                                                        Kadınlar
                                                    </button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="pills-tabContent">
                                                <div
                                                    class="tab-pane fade show active"
                                                    id="pills-1"
                                                    role="tabpanel"
                                                    aria-labelledby="pills-home-tab"
                                                    tabindex="0"
                                                >
                                                    <div class="servicesLists">
                                                        <div class="accordion accordion-flush" id="accordionFlushExampleMan">
                                                            @forelse($manServiceCategories as $manCategories)
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
                                                                            {{$manCategories->first()->categorys->name}}
                                                                            @php
                                                                                $checkedCount = 0;
                                                                            @endphp
                                                                            @foreach($manCategories as $service)
                                                                                @if(in_array($service->id, $serviceIds))
                                                                                    @php
                                                                                        $checkedCount++;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            {{"(".$checkedCount . ") Seçili"}}
                                                                        </button>
                                                                    </h2>
                                                                    <div
                                                                        id="flush-collapse-man-{{$loop->index}}"
                                                                        class="accordion-collapse {{$loop->first ? "" : "collapse"}}"
                                                                        data-bs-parent="#accordionFlushExampleMan"
                                                                    >
                                                                        <div class="accordion-body">
                                                                            <div class="accordionList">
                                                                                <div class="accordionListItem">
                                                                                    <div class="row">
                                                                                        @forelse($manCategories as $service)
                                                                                            <div class="col-lg-2">
                                                                                                <div class="servicesItem checkServicesItem">
                                                                                                    <input type="checkbox" value="{{$service->id}}" @checked(in_array($service->id, $serviceIds)) name="services[]"/>
                                                                                                    <div class="checkServicesItemContent">
                                                                                                        <div class="icon">
                                                                                                            <img
                                                                                                                src="/assets/images/services/ico-services-2.svg"
                                                                                                                alt=""
                                                                                                            />
                                                                                                        </div>
                                                                                                        <strong>{{$service->subCategory->name}}</strong>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        @empty
                                                                                        @endforelse
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                            @endforelse

                                                        </div>


                                                    </div>
                                                </div>
                                                <div
                                                    class="tab-pane fade"
                                                    id="pills-2"
                                                    role="tabpanel"
                                                    aria-labelledby="pills-profile-tab"
                                                    tabindex="0"
                                                >
                                                    <div class="servicesLists">
                                                        <div class="accordion accordion-flush" id="accordionFlushExampleWoman">
                                                            @forelse($womanServiceCategories as $womanCategories)
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
                                                                            {{$womanCategories->first()->categorys->name}}
                                                                            @php
                                                                                $checkedCount = 0;
                                                                            @endphp
                                                                            @foreach($womanCategories as $service)
                                                                                @if(in_array($service->id, $serviceIds))
                                                                                    @php
                                                                                        $checkedCount++;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            {{"(".$checkedCount . ") Seçili"}}
                                                                        </button>
                                                                    </h2>
                                                                    <div
                                                                        id="flush-collapse-woman-{{$loop->index}}"
                                                                        class="accordion-collapse {{$loop->first ? "" : "collapse"}}"
                                                                        data-bs-parent="#accordionFlushExampleWoman"
                                                                    >
                                                                        <div class="accordion-body">
                                                                            <div class="accordionList">
                                                                                <div class="accordionListItem">
                                                                                    <div class="row">
                                                                                        @forelse($womanCategories as $service)
                                                                                            <div class="col-lg-2">
                                                                                                <div class="servicesItem checkServicesItem">
                                                                                                    <input type="checkbox" value="{{$service->id}}" @checked(in_array($service->id, $serviceIds)) name="services[]"/>
                                                                                                    <div class="checkServicesItemContent">
                                                                                                        <div class="icon">
                                                                                                            <img
                                                                                                                src="/assets/images/services/ico-services-2.svg"
                                                                                                                alt=""
                                                                                                            />
                                                                                                        </div>
                                                                                                        <strong>{{$service->subCategory->name}}</strong>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        @empty
                                                                                        @endforelse
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            @empty
                                                            @endforelse
                                                        </div>


                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>
                </article>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn-pink" onclick="$('#select-service-form').submit()" style="border:none">Kaydet</button>
            </div>
        </div>
    </div>
</div>
