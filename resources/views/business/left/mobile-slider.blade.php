<div class="saloonDetailSliders mb-4 desktop-hidden">
    <div
        id=""
        class="owl-carousel owl-theme saloonDetailSlider1"
    >
        @forelse($business->sliders as $slider)
            <div class="item">
                <div class="saloonDetailSliderBigPhoto">
                    <img src="{{image($slider->image)}}" alt=""/>
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
                    src="{{image($slider->image)}}"
                    class="w-100"
                    alt=""
                />
            </div>
        </div>
        @empty
        @endforelse
    </div>
</div>
