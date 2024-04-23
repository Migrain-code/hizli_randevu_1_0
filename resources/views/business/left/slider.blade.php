<div class="saloonDetailSliders mb-4 mobile-hidden">
    <div id="" class="owl-carousel owl-theme saloonDetailSlider1">
        @foreach($business->gallery as $bSlider)
            <div class="item">
                <div class="saloonDetailSliderBigPhoto">
                    <img src="{{image($bSlider->way)}}" alt="{{$bSlider->name}}"/>
                </div>
            </div>
        @endforeach
    </div>
    <div id="" class="owl-carousel owl-theme saloonDetailSlider2">
        @foreach($business->gallery as $bSlider)
            <div class="item">
                <div class="saloonDetailSliderBigPhoto">
                    <img src="{{image($bSlider->way)}}" alt="{{$bSlider->name}}"/>
                </div>
            </div>
        @endforeach
    </div>
</div>
