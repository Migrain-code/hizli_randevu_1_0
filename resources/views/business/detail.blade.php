@extends('layouts.master')
@php
    $title = $business->name. " Hemen Randevu Al - Fiyatları ve Yorumları ". $business->cities->name. " ". $business->districts->name;
    $description = $business->name. " işletmesinin gerçek müşteri yorumları, fotoğrafları, kampanyaları, adresi ve çalışma saatlerini görüntüleyin. Ayrıca, ".$business->districts->name.", ".$business->cities->name." konumunu harita üzerinde bulun ve yol tarifi alın."
@endphp
@section('title', $title)
@section('description', $description)
@section('styles')
    <style>
        iframe {
            border-radius: 15px;
            width: 100%;
        }

        .detailRating .stars i {
            color: #535e8a;
            font-size: 18px;
        }

        .detailRating .stars i.active {
            color: var(--pink) !important;
        }

        .commentsText {
            width: 100%;
        }
        @media screen and (max-width: 768px) {
            .saloonDetailSliders .saloonDetailSlider1 .saloonDetailSliderBigPhoto img {
                border-radius: 15px;
                height: 260px;
                -o-object-fit: cover;
                object-fit: cover;
                -o-object-position: center;
                object-position: center;
            }
        }

    </style>
@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="my-5 py-2">
            <div class="container mobile-hidden">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('main')}}">Anasayfa</a></li>
                                <li class="breadcrumb-item"><a href="{{route('search.businessCategorySearch', $business->category->getSlug())}}">{{$business->category->getName()}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{$business->name}}
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
                            <div class="col-lg-6 order-2 order-lg-1">
                                @include('business.left.slider')
                                <!-- iletişim alanı -->
                                <div class="saloonDetailBox mb-4">
                                    @if(isset($business->phone))
                                        <a href="tel:0{{formatPhone($business->phone)}}" class="description mb-4 text-center d-flex justify-content-center align-items-center"
                                           style="background-color: rgb(43 117 73 / 10%);
                                            border-radius: 15px;
                                            text-decoration: none;
                                            padding: 10px;
                                            font-size: 24px;
                                            color: rgba(43, 117, 73, 1);">
                                            0{{formatPhone($business->phone)}}
                                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="ms-2">
                                                <path d="M21.6211 19.6326V17.9866C21.6211 17.1688 21.1232 16.4334 20.3639 16.1297L18.3297 15.316C17.364 14.9297 16.2633 15.3482 15.7981 16.2786L15.6211 16.6326C15.6211 16.6326 13.1211 16.1326 11.1211 14.1326C9.12109 12.1326 8.62109 9.63257 8.62109 9.63257L8.97511 9.45556C9.90547 8.99038 10.3239 7.88971 9.93764 6.92392L9.12398 4.88979C8.82025 4.13047 8.08484 3.63257 7.26703 3.63257H5.62109C4.51652 3.63257 3.62109 4.528 3.62109 5.63257C3.62109 14.4691 10.7845 21.6326 19.6211 21.6326C20.7257 21.6326 21.6211 20.7371 21.6211 19.6326Z" stroke="#2B7549FF" stroke-width="1.5" stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                    @endif

                                    <div class="detailTitle">Hakkında</div>
                                    <div class="detailBoxContent">
                                        {!! $business->about !!}
                                    </div>
                                </div>
                                <div class="saloonDetailBox mb-4" id="address">
                                    <div class="detailTitle ">Adres</div>
                                    <div class="detailBoxContent mb-3">
                                        {{$business->address}}
                                    </div>
                                    {!! $business->embed !!}

                                </div>
                                @include('business.left.personel.list')
                                @include('business.left.work-time')
                                @include('business.left.comment')
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2">
                                @include('business.left.mobile-slider')
                                <div class="saloonInfoBox">
                                    <div class="saloonInfoHeader">
                                        @include('business.right.header')
                                        @include('business.right.services')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            @include('business.left.gallery')

        </div>
    </article>

@endsection
@section('scripts')
    @include('business.left.personel-detail')
    <script>
        var lat = {{$business->lat}};
        var lng = {{$business->longitude}};
        function openGoogleMaps(){
            // Google Haritalar URL'sini oluşturun
            var mapsURL = 'https://www.google.com/maps?q=' + lat + ',' + lng;

            // Yeni bir pencerede Google Haritalar'ı açın
            window.open(mapsURL);
        }
    </script>

@endsection
