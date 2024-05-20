@extends('layouts.master')
@section('title', 'Paket Detayı')
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
                                    <a href="{{route('customer.packet.index')}}">Paket Alımlarım</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detay
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
                                   @include('customer.packet.summary')
                                    <div class="profileBox mb-3 packageSummary">
                                        <div class="profileTitle">Paket Özeti</div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>Paket Kodu</span>
                                            <span>#{{$packet->id}}</span>
                                        </div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>Alım Tarihi</span>
                                            <span>{{\Illuminate\Support\Carbon::parse($packet->seller_date)->format('d.m.Y H:i')}}</span>
                                        </div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>Hizmet Adı</span>
                                            <span>{{$packet->service->subCategory->getName() ?? ""}}</span>
                                        </div>
                                        <div
                                            class="packageSummaryItem d-flex align-items-center justify-content-between"
                                        >
                                            <span>Durumu</span>
                                            @if($packet->usages->sum('amount') == $packet->amount and $packet->payments->sum('price') == $packet->total)
                                                <span class="badge rounded-pill text-bg-success">Tamamlandı</span>
                                            @else
                                                @if($packet->usages->sum('amount') != $packet->amount)
                                                    <span class="badge rounded-pill text-bg-primary">({{$packet->amount - $packet->usages->sum('amount')}}) Kullanım Hakkınız Var</span>
                                                @else
                                                    @if($packet->payments->sum('price') != $packet->total)
                                                        <span class="badge rounded-pill text-bg-warning">Ödeme Tamamlanmadı</span>
                                                    @else
                                                        <span class="badge rounded-pill text-bg-danger ">Ödeme Tamamlandı</span>
                                                    @endif
                                                @endif


                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        @include('customer.packet.usages')
                                        @include('customer.packet.payments')
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
