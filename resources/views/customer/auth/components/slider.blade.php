<div class="formBoxSlider">
    <div class="owl-carousel owl-theme">
        @foreach($loginImages as $loginImage)
            <div class="item">
                <div class="formBoxSliderPhoto">
                    <img src="{{image($loginImage->image)}}" alt="" />
                </div>
                <div class="formBoxSliderText">
                    <strong>{{$loginImage->getTitle()}}</strong>
                    <span>{{$loginImage->getDescription()}}</span>
                </div>
            </div>
        @endforeach

    </div>
    <a href="javascript:;" class="sliderPrev">
        <svg
            width="9"
            height="16"
            viewBox="0 0 9 16"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M7.85937 15.2158L0.859375 8.21582L7.85938 1.21582"
                stroke="white"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
    </a>
    <a href="javascript:;" class="sliderNext">
        <svg
            width="10"
            height="16"
            viewBox="0 0 10 16"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M1.31934 15.2158L8.31934 8.21582L1.31934 1.21582"
                stroke="white"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
    </a>
</div>
