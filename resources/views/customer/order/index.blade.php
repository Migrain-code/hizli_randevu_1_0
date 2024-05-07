@extends('layouts.master')
@section('meta_keys', "Ürün Alımlarım")
@section('meta_description', config('settings.meta_description'))
@section('styles')
    <style>
        @media (max-width: 1050px) {
            .table {
                overflow: hidden;
            }

            .table table {
                width: 100%;
                table-layout: fixed;
            }
            .table tr{
                background-color: #ececec91;
                border-radius: 15px;
            }
            .table tbody,
            .table thead,
            .table tr,
            .table td,
            .table th {
                display: block;
            }

            .table tr {
                margin-bottom: 1rem;
            }

            .table td,
            .table th {
                display: flex;
                align-items: center;
                border-bottom: 1px solid #dee2e6;
                padding: 0.75rem;
                min-height: 50px;
                word-wrap: break-word;
                white-space: normal;
                line-height: 0px !important;
            }

            .table th {
                display: none;
            }

            .table td::before {
                content: attr(data-label);
                font-weight: bold;
                display: inline-block;
                width: 120px; /* İlgili alanın genişliğini buradan ayarlayabilirsiniz */
                margin-right: 5px;
                text-align: left;
            }
        }
    </style>

@endsection
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="mt-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('customer.favorite.index')}}">Hesabım</a></li>

                                <li class="breadcrumb-item active" aria-current="page">
                                    Siparişlerim
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
                                <div id="profileContentBox">
                                    <div class="profileTitle">Satın Aldığınız Ürünler</div>
                                    <div class="profileTable">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Sipariş Kodu</th>
                                                    <th scope="col">İşletme Adı</th>
                                                    <th scope="col">Ürün Adı</th>
                                                    <th scope="col">Adet</th>
                                                    <th scope="col">Fiyat</th>
                                                    <th scope="col">Ödeme Türü</th>
                                                    <th scope="col">Sipariş Tarihi</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($orders as $order)
                                                    <tr>
                                                        <td data-label="Sipariş kodu"># {{$order->id}}</td>
                                                        <td data-label="İşletme Adı"><a href="{{route('business.detail', $order->business->slug)}}" target="_blank">{{$order->business->name}}</a></td>
                                                        <td data-label="Ürün Adı">{{$order->product->name}}</td>
                                                        <td data-label="Adet">{{$order->piece}}</td>
                                                        <td data-label="Fiyat">{{$order->total}}</td>
                                                        <td data-label="Ödeme Türü">{{$paymentTypes[$order->payment_type]}}</td>
                                                        <td data-label="Sipariş Tarihi" class="date">
                                                            <span>
                                                                {{$order->created_at->translatedFormat('d F y')}}
                                                            </span>
                                                            <span>
                                                                {{$order->created_at->translatedFormat('H:i')}}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty

                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                            {!! $orders->links() !!}
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
