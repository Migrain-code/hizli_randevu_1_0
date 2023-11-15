@if(isset(request()["request"]["step"]))
<div class="servicesBox">
    <div
        class="d-flex align-items-center justify-content-between"
    >
        <div class="stepsTitle d-flex align-items-start">
            <div class="step">4</div>
            <div class="text"><span>Saat Seçimi</span></div>

        </div>
    </div>
    <div class="servicesBoxContent">
        <form id="step-3-form" method="post" action="">
            @csrf
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="timePickers">

                        <div id="personelTimes">

                        </div>

                    </div>

                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
                <!-- Add Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

        </form>

    </div>
</div>
@endif
