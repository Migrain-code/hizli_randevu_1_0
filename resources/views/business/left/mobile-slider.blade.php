<div class="saloonDetailSliders mb-4 desktop-hidden">
    <div
        id=""
        class="owl-carousel owl-theme saloonDetailSlider1"
    >
        @forelse($business->sliders as $slider)
            <div class="item">
                <div class="saloonDetailSliderBigPhoto">
                    <img src="/assets/images/sliderbig.png" alt=""/>
                </div>
            </div>
        @empty
        @endforelse

    </div>
    <div
        id=""
        class="owl-carousel owl-theme saloonDetailSlider2"
    >
        @forelse($business->sliders as $slider)
            <div class="item">
            <div class="saloonDetailSliderMiniPhoto">
                <img
                    src="/assets/images/slidermini.png"
                    class="w-100"
                    alt=""
                />
            </div>
        </div>
        @empty
        @endforelse
    </div>
</div>
