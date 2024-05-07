@extends('layouts.master')
@section('title', 'Hesabım')
@section('styles')
    <style>
        .card {
            border: 0;
            box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.02);;
            background-color: #ffffff;
        }
        .card.card-flush > .card-header {
            border-bottom: 0 !important;
        }
        .card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            flex-wrap: wrap;
            min-height: 70px;
            padding: 0 2.25rem;
            color: black;
            background-color: transparent;
            border-bottom: 1px solid #eff2f5;
        }
        .bullet {
            display: inline-block;
            background-color: #B5B5C3;
            border-radius: 6px;
            width: 8px;
            height: 4px;
            flex-shrink: 0;
        }
        .card .card-header .card-title, .card .card-header .card-title .card-label {
            font-weight: 500;
            font-size: 1.1rem;
            color: #434658;
        }
        .border-dashed {
            border-style: dashed !important;
            border-color: #E4E6EF;
        }
        .bg-light-primary {
            background-color: #f1faff !important;
        }
        .rounded {
            border-radius: 0.475rem !important;
        }
        .p-6 {
            padding: 1.5rem !important;
        }
        .border-primary {
            --bs-border-opacity: 1;
            border-color: rgba(0, 158, 247, var(--bs-border-opacity)) !important;
        }
        .apexcharts-legend.apx-legend-position-bottom .apexcharts-legend-series, .apexcharts-legend.apx-legend-position-top .apexcharts-legend-series {
            display: flex;
            align-items: center;
            justify-content: center;
            /* margin: 0px 15px !important; */
            padding-right: 14px;
            padding-left: 15px;
        }
    </style>
    <link rel="stylesheet" href="/assets/css/apexcharts.css">
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
                                @include('customer.home.charts')

                                @include('customer.home.product-advert')
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
                        <img src="{{image($footer->image)}}" class="w-100" alt="">
                    </a>
                @endforeach
            </div>

        </div>
        </div>
    </article>

@endsection
@section('scripts')
    <script src="/assets/js/apexcharts.min.js"></script>

    <script>
        var appointmentData = [
            {!! $customer->appointments->whereIn('status', [1])->count() !!},
            {!! $customer->appointments->whereIn('status', [2])->count() !!},
            {!! $customer->appointments->whereIn('status', [0])->count() !!},
            {!! $customer->appointments->whereIn('status', [3])->count() !!},
            {!! $customer->appointments->whereIn('status', [4])->count() !!},
        ];
        var allZeroes = appointmentData.every(function(value) {
            return value === 0;
        });

        var colors = ['#008ffb', '#00e396', '#feb019', '#ff4560', '#775dd0'];
        var options = {
            series: [{
                data: appointmentData
            }],
            chart: {
                height: 350,
                width: 550,
                type: 'bar',
                events: {
                    click: function(chart, w, e) {
                        // console.log(chart, w, e)
                    }
                }
            },
            colors: colors,
            plotOptions: {
                bar: {
                    columnWidth: '35%',
                    distributed: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            responsive: [{
                breakpoint: 1400,
                options: {
                    chart: {
                        width: '270',
                    },
                    legend: {
                        position: 'bottom'
                    }
                },
                xaxis: {
                    categories: [
                        ['Onaylandı'],
                        ['Tamamlandı'],
                        ['Onaylanmadı'],
                        ['İptal Edildi'],
                        ['Gelmedi'],
                    ],
                    labels: {
                        style: {
                            colors: colors,
                            fontSize: '11px',
                            fontWeight: 'bold',
                        }
                    }
                }
            }],
            xaxis: {
                categories: [
                    ['Onaylandı'],
                    ['Tamamlandı'],
                    ['Onaylanmadı'],
                    ['İptal Edildi'],
                    ['Gelmedi'],
                ],
                labels: {
                    style: {
                        colors: colors,
                        fontSize: '14px',
                        fontWeight: 'bold',
                    }
                }
            }
        };


        var chartPie = new ApexCharts(document.querySelector("#kt_docs_google_chart_pie"), options);
    </script>

    @php
        use Illuminate\Support\Carbon;
        $year = now()->year;
        $months = [];
        for ($i = 1; $i <= 12; $i++){
            $month = $year."-".$i. "-01";
            $months[] = Carbon::parse($month)->translatedFormat('F');
        }

    @endphp
    <script>
        var months = @json($months);
        var packageSales = @json($customer->getMonthlyPackageSales());
        var productSales = @json($customer->getMonthlyProductSales());
    </script>
    <script>
        var optionsLine = {
            series: [{
                name: 'Siparişler',
                type: 'area',
                data: productSales
            }, {
                name: 'Paketler',
                type: 'line',// or area
                data: packageSales
            }],
            chart: {
                height: 350,
                width: 500,
                type: 'line',
            },
            responsive: [{
                breakpoint: 1400,
                options: {
                    chart: {
                        width: '300',
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            stroke: {
                curve: 'smooth'
            },
            fill: {
                type:'solid',
                opacity: [0.35, 1],
            },
            labels: months,
            markers: {
                size: 0
            },
            yaxis: [
                {
                    title: {
                        text: 'Ürün Satışları',
                    },
                },
                {
                    opposite: true,
                    title: {
                        text: 'Paket Satışları',
                    },
                },
            ],
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (y) {
                        if(typeof y !== "undefined") {
                            return  y.toFixed(0) + " Adet";
                        }
                        return y;
                    }
                }
            }
        };

        var chartLine = new ApexCharts(document.querySelector("#kt_project_overview_graph"), optionsLine);

        var isChartRendered = false;


        $(function (){
            // Grafik render edilmediyse render et
            if (!isChartRendered) {
                chartPie.render();
                chartLine.render();
                isChartRendered = true;
            }

        });
    </script>
@endsection
