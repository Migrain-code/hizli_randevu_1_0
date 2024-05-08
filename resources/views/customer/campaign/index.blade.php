@extends('layouts.master')
@section('title', 'Kampanyalarım')
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

                                <li class="breadcrumb-item active" aria-current="page">
                                    Kampanyalarım
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
                                <div class="campaignList">
                                    <div class="row">
                                        @forelse($campaigns as $campaign)
                                            <div class="col-lg-6 col-xl-3">
                                                <div class="campaignItem">
                                                    <div class="campaignPhoto">
                                                        <a href="{{route('business.detail', $campaign->campaign->business->slug)}}">
                                                            <img
                                                                src="{{$campaign->campaign->business->gallery->count() > 0 ? image($campaign->campaign->business->gallery()->first()->way) : image("storage/default/business.png") }}"
                                                                alt="{{$campaign->campaign->business->gallery->count() > 0 ? $campaign->campaign->business->gallery()->first()->name : "default_image.png"}}"
                                                            />
                                                            <span class="featured"><i>Kampanya</i></span>
                                                        </a>
                                                    </div>
                                                    <div class="campaignContent">
                                                        <div class="campaignContentTop">
                                                            <a href="{{route('business.detail', $campaign->campaign->business->slug)}}" class="campaignTitle">{{$campaign->campaign->business->name}}</a>
                                                            <span>{{str()->limit($campaign->campaign->getTitle(), 50)}}</span>
                                                        </div>
                                                        <div class="campaignContentDate">
                                                            <span class="d-flex align-items-center justify-content-between">
                                                                <span>Başlangıç</span>
                                                                <span>{{\Illuminate\Support\Carbon::parse($campaign->campaign->start_time)->format('d.m.Y H:i')}}</span>
                                                            </span>
                                                            <span class="d-flex align-items-center justify-content-between">
                                                                <span>Bitiş</span>
                                                                <span>{{\Illuminate\Support\Carbon::parse($campaign->campaign->end_date)->format('d.m.Y H:i')}}</span>
                                                            </span>
                                                        </div>
                                                        <div class="campaignContentLine"></div>
                                                        <div class="campaignDetailLink">
                                                            <a href="{{route('customer.campaign.detail', $campaign->campaign->getSlug())}}">
                                                                Detayları Gör
                                                                <svg
                                                                    width="9"
                                                                    height="17"
                                                                    viewBox="0 0 9 17"
                                                                    fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                >
                                                                    <path
                                                                        d="M0.75 0.884766L8.25 8.38477L0.75 15.8848"
                                                                        stroke="#43506E"
                                                                        stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                    />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-warning my-2">
                                                Kampanya Kaydınız Bulunamadı
                                            </div>
                                        @endforelse

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
