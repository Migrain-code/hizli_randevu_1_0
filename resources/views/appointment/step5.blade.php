@extends('layouts.master')

@section('styles')
    <style>
        .servicesSuccess {
            margin: 0 !important;
            margin-top: 50px !important;
        }
    </style>
@endsection
@section('content')
    <article id="page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <section id="pageContent">
                        <div class="row mb-0">
                            <div class="col-lg-12">
                                <div
                                    class="servicesSuccess d-flex align-items-center justify-content-center"
                                >
                                    <div class="servicesSuccessContent">
                                        <img src="/assets/images/success.svg" alt="" />
                                        <strong>Randevu Başarıyla Alındı!!</strong>
                                        <p>
                                            <strong>
                                                {{$business->name}}
                                            </strong>

                                            <strong> işletmesine {{$appointment->start_time}} - {{$appointment->end_time}} arasında randevu alındı</strong>

                                        </p>
                                        <a href="/" class="btn-pink">Anasayfaya Dön</a>
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
