@if($bottomAds->count() > 0)
    <div class="bannerSlider">
        <div class="owl-carousel owl-theme">
            @foreach($bottomAds as $bottom)
                <div class="item">
                    <a href="{{$bottom->link}}" target="_blank">
                        <img src="/assets/images/bannerslider1.png" alt="">
                    </a>
                </div>
            @endforeach

        </div>
        <a href="javascript:;" class="sliderPrev">
            <img src='/assets/images/icons/ico-slider-left.svg'>
        </a>
        <a href="javascript:;" class="sliderNext">
            <img src='/assets/images/icons/ico-slider-right.svg'>
        </a>

    </div>

@endif
