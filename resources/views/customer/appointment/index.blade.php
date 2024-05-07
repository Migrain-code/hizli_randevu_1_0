@extends('layouts.master')
@section('title', 'Randevularım')
@section('meta_description', 'Tüm Randevularım')
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
                min-height: 50px; /* min-height ayarını düşürerek veya kaldırarak deneyin */
                word-wrap: break-word;
                white-space: normal;
                line-height: 1.5; /* line-height değerini ayarlayın */
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
    <style>

       .appointmentStatus{
            font-size: 12px !important;
            line-height: 10px !important;
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
                                <li class="breadcrumb-item"><a href="{{route('customer.home')}}">Hesabım</a></li>

                                <li class="breadcrumb-item active" aria-current="page">
                                    Randevularım
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
                                    <div class="profileTitle">
                                        Geçmiş Randevularınızın Listesi
                                    </div>
                                    <div class="profileTable">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Randevu Kodu</th>
                                                    <th scope="col">İşletme Adı</th>
                                                    <th scope="col">Randevu Tarihi</th>
                                                    <th scope="col">Durumu</th>
                                                    <th scope="col">İşlemler</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($customer->appointments()->paginate(setting('speed_pagination_number')) as $appointment)
                                                        <tr>
                                                            <td data-label="Randevu kodu">#{{$appointment->id}}</td>
                                                            <td data-label="İşletme Adı">{{$appointment->business->name}}</td>
                                                            <td data-label="Randevu Tarihi" class="date">{{$appointment->start_time}}</td>
                                                            <td data-label="Durumu">{!!$appointment->status('html') !!}</td>
                                                            <td data-label="İşlemler"><a href="{{route('customer.appointment.detail', $appointment->id)}}" class="btn-pink btn-xs">Detay</a></td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6">
                                                                <div class="alert alert-warning">
                                                                    Geçmiş Randevu Kaydınız Bulunamadı
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        {!! $customer->appointments()->paginate(setting('speed_pagination_number'))->links() !!}
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
