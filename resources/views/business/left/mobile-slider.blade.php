<div class="saloonDetailSliders mb-4 desktop-hidden">
    <div
        id=""
        class="owl-carousel owl-theme saloonDetailSlider1"
    >
        @forelse($business->gallery as $slider)
            <div class="item">
                <div class="saloonDetailSliderBigPhoto">
                    <img src="{{image($slider->way)}}" alt="{{$slider->name}}"/>
                </div>
            </div>
        @empty
        @endforelse

    </div>
    <div
        id=""
        class="owl-carousel owl-theme saloonDetailSlider2"
    >
        @forelse($business->gallery as $slider)
            <div class="item">
            <div class="saloonDetailSliderMiniPhoto">
                <img
                    src="{{image($slider->way)}}"
                    class="w-100"
                    alt=""
                />
            </div>
        </div>
        @empty
        @endforelse
    </div>
</div>
