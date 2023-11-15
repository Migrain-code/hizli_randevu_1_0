@extends('layouts.master')
@section('title', 'Randevu Detayı')
@section('meta_description', config('settings.meta_description'))
@section('styles')

@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="mt-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('customer.home')}}">Hesabım</a></li>

                                <li class="breadcrumb-item">
                                    <a href="{{route('customer.appointment.index')}}">Randevular</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Randevu Detayı
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
                        <div class="d-flex align-items-start">
                            @include('customer.layouts.menu')
                            <div class="profileContent">
                                <div id="packageDetail">
                                    <div class="profileBox mb-3 packageSummary">
                                        <div class="profileTitle">Randevu Özeti</div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>Randevu Kodu</span>
                                            <span>#{{$appointment->id}}</span>
                                        </div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>Randevu Tarihi</span>
                                            <span>{{$appointment->start_time}}</span>
                                        </div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>İşletme Adı</span>
                                            <span>
                                              <a target="_blank" href="{{route('business.detail', $appointment->business->slug)}}" class="text-primary">{{$appointment->business->name}}</a>
                                            </span>
                                        </div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>Durumu</span>
                                            <span>
                                                 {!! $appointment->status('html') !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @include('customer.appointment.services')
                                        @include('customer.appointment.comment')
                                    </div>
                                </div>
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
