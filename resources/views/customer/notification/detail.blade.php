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
                                    <a href="{{route('customer.notification')}}">Bildirimler</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Bildirim Detayı
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <section id="pageContent">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="pe-4">
                                    {{-- <div class="pageBanner mb-5">
                                        <img
                                            src="assets/images/pageBanner.png"
                                            class="w-100"
                                            alt=""
                                        />
                                    </div>--}}

                                    <h2 class="pageTitle mb-5">
                                        {{$notification->title}}
                                    </h2>

                                    <div class="pageText">
                                        {!! $notification->content !!}
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
