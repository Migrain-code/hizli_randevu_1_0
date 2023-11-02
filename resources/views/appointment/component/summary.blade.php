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

                </span>
            </div>
        </div>
        <div class="summaryItem">
            <div
                class="d-flex align-items-center justify-content-between"
            >
                <span>Tarih</span>
                <span>2023-09-23</span>
            </div>
        </div>
        <div class="summaryItem">
            <div
                class="d-flex align-items-center justify-content-between"
            >
                <span>Saat</span>
                <span>21:00</span>
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
                        <a href="javascript:;"
                        ><svg
                                width="15"
                                height="15"
                                viewBox="0 0 15 15"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M4.2207 10.4158L9.99541 4.64107"
                                    stroke="#43506E"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                                <path
                                    d="M4.2207 4.64087L9.99541 10.4156"
                                    stroke="#43506E"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </a>
                    </div>

                @empty
                    <div class="alert alert-waring"><u>Lütfen Hizmet Seçiniz</u></div>
                @endforelse

            </div>
        </div>
    </div>
</div>
