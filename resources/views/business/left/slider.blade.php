<div class="saloonDetailSliders mb-4 mobile-hidden">
    <div id="" class="owl-carousel owl-theme saloonDetailSlider1">
        @foreach($business->sliders as $gallery)
            <div class="item">
                <div class="saloonDetailSliderBigPhoto">
                    <img src="/assets/images/sliderbig.png" alt="{{$gallery->name}}"/>
                </div>
            </div>
        @endforeach
    </div>
    <div id="" class="owl-carousel owl-theme saloonDetailSlider2">
        @foreach($business->sliders as $gallery)
            <div class="item">
                <div class="saloonDetailSliderBigPhoto">
                    <img src="/assets/images/sliderbig.png" alt="{{$gallery->name}}"/>
                </div>
            </div>
        @endforeach
    </div>
</div>
