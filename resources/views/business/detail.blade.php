@extends('layouts.master')
@section('title', 'İşletme Detayı')
@section('styles')
    <style>
        iframe {
            border-radius: 15px;
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
    </style>
@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="my-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('main')}}">Anasayfa</a></li>
                                <li class="breadcrumb-item"><a href="#">İşletmeler</a></li>
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
                                @include('business.left.contact')
                                <div class="saloonDetailBox mb-4">
                                    <div class="detailTitle">Hakkında</div>
                                    <div class="detailBoxContent">
                                        {{$business->about}}
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
@endsection
