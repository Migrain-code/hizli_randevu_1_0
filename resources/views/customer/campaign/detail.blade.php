@extends('layouts.master')
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
                                <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                                <li class="breadcrumb-item">
                                    <a href="{{route('customer.campaign.index')}}">Kampanyalar</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Kampanya Detayı
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
                        <div class="row mb-5">
                            <div class="col-12 border-end">
                                <div class="pe-md-4">
                                    <div class="pageBanner mb-5">
                                        <img
                                            style="max-height: 550px;object-fit: cover;"
                                            src="{{image($campaign->image)}}"
                                            class="w-100"
                                            alt=""
                                        />
                                    </div>

                                    <h2 class="pageTitle mb-5">
                                        {{$campaign->getTitle()}}
                                    </h2>
                                    <div class="postMeta d-flex align-items-center flex-wrap">
                                        <div class="metaItem user d-flex align-items-center">
                                            <img src="/assets/images/blogitem.png" alt="" />
                                            <span>{{$campaign->business->name}}</span>
                                        </div>
                                        <div class="metaItem d-flex align-items-center">
                                            <img
                                                src="/assets/images/icons/ico-calendar.svg"
                                                alt=""
                                            />
                                            <span>{{\Illuminate\Support\Carbon::parse($campaign->start_time)->format('d.m.Y H:i')}}</span>
                                        </div>
                                        <div class="metaItem d-flex align-items-center">
                                            <img
                                                src="/assets/images/icons/ico-calendar.svg"
                                                alt=""
                                            />
                                            <span>{{\Illuminate\Support\Carbon::parse($campaign->end_date)->format('d.m.Y H:i')}}</span>
                                        </div>
                                        <div class="metaItem d-flex align-items-center">
                                            <img src="/assets/images/icons/ico-users.svg" alt="" />
                                            <span>Kod {{$campaign->code}}</span>
                                        </div>
                                        <div class="metaItem d-flex align-items-center">
                                            <img src="/assets/images/icons/discount-label.svg" alt="" />
                                            <span>İndirim %{{$campaign->discount}}</span>
                                        </div>
                                    </div>
                                    <div class="pageText">
                                        {!! $campaign->getDescription() !!}
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
