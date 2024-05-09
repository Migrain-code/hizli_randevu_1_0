@extends('layouts.master')

@section('styles')
    <style>
        .servicesSuccess {
            margin: 0 !important;
            margin-top: 50px !important;
        }
        .servicesSuccess .servicesSuccessContent strong {
            display: block;
            font-weight: 400;
            font-size: 21.6009px;
            line-height: 41px;
            color: var(--lightblue);
            margin-bottom: 20px;
            text-align: center;
        }
        .servicesSuccess .servicesSuccessContent strong {
            display: block;
            font-weight: 600;
            font-size: 21.6009px;
            line-height: 26px;
            color: var(--lightblue);
            margin-bottom: 20px;
            text-align: center;
        }
        .servicesSuccess .servicesSuccessContent {
            text-align: center;
            max-width: 700px;
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
                                        <strong>Randevu talebiniz başarıyla kaydedildi. İşletmemizden kısa bir süre içinde yanıt alacaksınız.</strong>
                                        <p>
                                            <strong> "İlginiz için teşekkür ederiz!"</strong>
                                        </p>
                                        @if(auth('customer')->check())
                                            <a href="{{route('customer.appointment.index')}}" class="btn-pink">Randevularıma Git</a>
                                        @else
                                            <a href="/" class="btn-pink">Anasayfaya Dön</a>
                                        @endif

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
