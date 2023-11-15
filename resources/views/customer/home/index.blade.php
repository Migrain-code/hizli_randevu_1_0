@extends('layouts.master')
@section('title', 'Hesabım')
@section('styles')
    <style>

    </style>
@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="mt-5  py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Profil</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Hesabım</li>
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
                                @include('customer.home.top-ads')
                                @include('customer.home.summary')
                                @include('customer.home.product-ads')
                                @include('customer.home.appointment')
                                @include('customer.home.bottom-slider')
                            </div>

                        </div>
                    </section>

                </div>
            </div>
        </div>
        <div class="profileFooterBanner mt-5 pt-5">
            <div class="d-flex align-items-center">
               @foreach($footerAds as $footer)
                    <a href="{{$footer->link}}" target="_blank">
                        <img src="/assets/images/profileBanner1.png" class="w-100" alt="">
                    </a>
               @endforeach
            </div>

        </div>
        </div>
    </article>

@endsection
@section('scripts')

@endsection
