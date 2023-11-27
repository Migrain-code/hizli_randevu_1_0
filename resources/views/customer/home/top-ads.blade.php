@if($topAds->count() > 0)
    <section id="bigSlider" class="mb-5 profileSlider">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bigSliderContent">
                        <div class="owl-carousel owl-theme">
                            @foreach($topAds as $top)
                                <div class="item">
                                    <div class="profileSliderItem"
                                         style="background-image: url('{{image($top->image)}}');">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <strong>{{$top->getTitle()}}</strong>
                                                <p>{{$top->getDescription()}}.</p>
                                                <a href="{{$top->link}}" target="_blank">Ürüne Bak</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profileSliderPhoto"><img
                                            src="{{image($top->logo)}}" alt="">
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="sliderArrow">
                            <a href="javascript:;" class="sliderPrev">
                                <img src='/assets/images/icons/ico-slider-left.svg'>
                            </a>
                            <a href="javascript:;" class="sliderNext">
                                <img src='/assets/images/icons/ico-slider-right.svg'>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif
