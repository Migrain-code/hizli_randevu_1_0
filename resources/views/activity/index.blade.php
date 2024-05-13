@extends('layouts.master')
@section('title', 'Kuaförler - Berberler - Güzellik salonları Etkinlikleri')
@section('description', 'Güzelliğe Dair Her Şey: Kuaförler, Berberler ve Güzellik Salonlarına Yönelik Canlı Etkinlikler ve Atölyeler Etkinlik Takvimleri.')
@section('styles')

@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="my-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Etkinlikler
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        @if($topImages->count() > 0)
            <section id="bigSlider" class="mb-5">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="bigSliderContent">
                                <div class="owl-carousel owl-theme">
                                    @forelse($topImages as $top)
                                        <div class="item">
                                            <a href="{{$top->link}}" target="_blank" >
                                                <img src="{{image($top->image)}}" alt=""  style="height: 350px !important"/>
                                            </a>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                                <div class="sliderArrow">
                                    <a href="javascript:;" class="sliderPrev">
                                        <img src="/assets/images/icons/ico-slider-left.svg" />
                                    </a>
                                    <a href="javascript:;" class="sliderNext">
                                        <img src="/assets/images/icons/ico-slider-right.svg" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        @endif
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <section id="pageContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="homeEventsList">
                                    @forelse($activities as $activity)
                                        <a href="{{route('activity.detail', $activity->slug)}}" class="d-flex align-items-center">
                                            <span class="date">
                                              <strong>{{\Illuminate\Support\Carbon::parse($activity->start_time)->format('d')}}</strong>
                                              <span>{{\Illuminate\Support\Carbon::parse($activity->start_time)->translatedFormat('F')}}</span>
                                              <span>{{\Illuminate\Support\Carbon::parse($activity->start_time)->format('Y')}}</span>
                                            </span>
                                            <span class="text">
                                                {{$activity->getTitle()}}
                                            </span>
                                        </a>
                                    @empty
                                        <div class="alert alert-warning mt-3 text-center">Etkinlik Bulunamadı</div>
                                    @endforelse
                                </div>
                                <div class="my-2 d-flex justify-content-center">
                                    {!! $activities->links() !!}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div id="eventDatePicker" class="eventListDate mb-4"></div>
                                @forelse($ads as $ad)
                                    <a href="{{$ad->link}}" target="_blank" class="eventDateBanner d-block mb-4">
                                        <img
                                            src="{{image($ad->image)}}"
                                            class="img-fluid"
                                            alt=""
                                            style="border-radius: 15px"
                                        />
                                    </a>
                                @empty
                                @endforelse

                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </article>
@endsection

@section('scripts')

@endsection
