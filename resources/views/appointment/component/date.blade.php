@if(isset(request()["request"]["step"]))
<div class="servicesBox">
    <div
        class="d-flex align-items-center justify-content-between"
    >
        <div class="stepsTitle d-flex align-items-start">
            <div class="step">3</div>
            <div class="text"><span>Tarih Seçimi</span></div>
        </div>
        <span>Bugün {{now()->format('d.m.Y')}}</span>
    </div>
    <div class="servicesBoxContent ps-0">
        <div class="dateSlider">
            <div class="owl-carousel">
                @forelse($remainingDate as $date)
                    <div class="item">
                        <div class="dateSliderRadio">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="flexRadioDefault"
                                id="flexRadioDefault1"
                                data-date="{{$date->format('Y-m-d')}}"
                                onclick="clickedDate('{{$date->toDateString()}}')"
                                @if($date->format('d.m.Y') == now()->format('d.m.Y')) checked @endif
                            />
                            <div class="dateSliderRadioText">
                                <i>{{$date->translatedFormat('D')}}</i>
                                <strong>{{$date->translatedFormat('d')}}</strong>
                                <i>{{$date->translatedFormat('F')}}</i>
                            </div>
                        </div>
                    </div>

                @empty
                @endforelse


            </div>
        </div>
    </div>
</div>
@endif
