@extends('layouts.master')
@section('title', 'Etkinlikler')
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
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <section id="pageContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="homeEventsList">
                                    @foreach($activities as $activity)
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
                                    @endforeach
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
