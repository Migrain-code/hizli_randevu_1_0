@extends('layouts.master')
@section('title', "Paket Satın Alımlarım")
@section('meta_description', "Paket Alımlarım")
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
                                <li class="breadcrumb-item"><a href="#">Hesabım</a></li>

                                <li class="breadcrumb-item active" aria-current="page">
                                    Paket Alımlarım
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
                                    <div class="profileTitle">Satın Aldığınız Paketler</div>
                                    <div class="profileTable">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Paket Kodu</th>
                                                    <th scope="col">İşletme Adı</th>
                                                    <th scope="col">Kalan Adet</th>
                                                    <th scope="col">Fiyat</th>
                                                    <th scope="col">Türü</th>
                                                    <th scope="col">Sipariş Tarihi</th>
                                                    <th scope="col">İşlemler</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($packets as $packet)
                                                    <tr>
                                                        <td data-label="Sipariş kodu"># {{$packet->id}}</td>
                                                        <td data-label="İşletme Adı">{{$packet->business->name}}</td>
                                                        <td data-label="Kalan adet">{{$packet->amount - $packet->usages->sum('amount')}}</td>
                                                        <td data-label="Toplam Ödeme">{{$packet->total - $packet->payments->sum('price')}}</td>
                                                        <td data-label="Türü">{{$packageTypes[$packet->type]}}</td>
                                                        <td data-label="Sipariş Tarihi" class="date">
                                                            <span>{{$packet->created_at->translatedFormat('d F y')}}</span><span>{{$packet->created_at->translatedFormat('H:i')}}</span>
                                                        </td>
                                                        <td data-label="İşlemler">
                                                            <a class="btn-pink btn-sm btn-rounded" href="{{route('customer.packet.detail', $packet->id)}}">
                                                                Detaylar
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8">
                                                            <div class="alert alert-warning">
                                                                Paket Kaydınız Bulunamadı
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center my-2">
                                        {{$packets->links()}}
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
