@if($appointments->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <div class="pageTab">
                <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-1-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-1" type="button"
                                role="tab" aria-controls="pills-1" aria-selected="true">
                            Son Randevularım</button>
                    </li>

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="saloonList">
                            <div class="row">
                                @forelse($appointments as $appointment)
                                    <div class="col-lg-3">
                                        <div class="saloonItem">
                                            <div class="saloonPhoto">
                                                <a href="{{route('business.detail', $appointment->business->slug)}}">
                                                    <img src="/assets/images/saloonphoto.png"
                                                         alt="">
                                                    @if($appointment->business->order_number > 0)
                                                        <span class="featured"><i>Öne
                                                                                    Çıkan</i></span>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="saloonItemHeader">
                                                <a href="javascript:;">{{$appointment->business->name}}</a>
                                                <p>{{ucfirst($appointment->business->cities->name). " / ". $appointment->business->districts->name}}</p>
                                                <div
                                                    class="rating d-flex align-items-center justify-content-between">
                                                    {{\Illuminate\Support\Carbon::parse($appointment->start_time)->format('d.m.Y')}}
                                                    <span>
                                                                                    {{\Illuminate\Support\Carbon::parse($appointment->start_time)->format('H:i')}}
                                                                                </span>
                                                </div>
                                            </div>
                                            <div class="saloonItemBottom">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="price">
                                                            <strong>{{$appointmentTotals[$loop->index]}} TL</strong>
                                                            <span><u onclick="window.location.href='{{route('business.detail', $appointment->business->slug)}}'" style="cursor: pointer;">Detay</u></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6" style="text-align: right;">
                                                        {!! $appointment->status('html') !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endif
