@extends('layouts.master')
@section('title', 'Anasayfa')
@section('description', 'Description')
@section('content')
    <article id="page">
        <section id="breadcrumbs" class="my-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('main')}}">Anasayfa</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    İşletmeler
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section id="pageContent">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="pageFilter mb-5">
                            <form class="row" method="post" id="serviceForm" action="{{route('search.cityAndServiceCategory')}}">
                                @csrf
                                <div class="col-lg-4">
                                    <div
                                        class="customSelect iconSelect servicesSelect customTomSelect"
                                    >
                                        <select class="tomSelect" name="service_id">
                                            <option value="">Hizmet seçiniz</option>
                                            @forelse($services as $service)
                                                <option value="{{$service->id}}">{{$service->name}}</option>
                                            @empty

                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div
                                        class="customSelect iconSelect servicesSelect customTomSelect"
                                    >
                                        <select class="tomSelect" name="city_id">
                                            <option value="">Şehir seçiniz</option>
                                            @forelse($cities as $city)
                                                <option value="{{$city->id}}">{{$city->name}}</option>
                                            @empty

                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div
                                    class="col-lg-4 d-flex align-items-center justify-content-end"
                                >
                                    <a href="javascript:;" onclick="$('#serviceForm').submit()" class="btn-pink">
                                        <svg
                                            class="me-4"
                                            width="22"
                                            height="23"
                                            viewBox="0 0 22 23"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M10.4344 20.4137C15.5996 20.4137 19.7868 16.2265 19.7868 11.0614C19.7868 5.89619 15.5996 1.70898 10.4344 1.70898C5.26923 1.70898 1.08203 5.89619 1.08203 11.0614C1.08203 16.2265 5.26923 20.4137 10.4344 20.4137Z"
                                                stroke="white"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                            <path
                                                d="M16.9395 18.0518L20.6061 21.7089"
                                                stroke="white"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                        Ara
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="categoryList mb-5">
                            <div
                                class="categoryListTop d-flex flex-wrap align-items-center"
                            >
                                @foreach($categories->take(4) as $category)
                                    <a href="{{route('search.businessCategorySearch', $category->slug)}}">{{ $category->name }}</a>
                                @endforeach
                                <a href="javascript:;" class="moreCategoryLink"
                                >Tümünü Gör
                                    <svg
                                        class="ms-2"
                                        width="18"
                                        height="10"
                                        viewBox="0 0 18 10"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M16.5 1.01465L9 8.51465L1.5 1.01465"
                                            stroke="#43506E"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </a>
                            </div>
                            <div class="categoryListMore flex-wrap align-items-center">
                                @foreach($categories->skip(4) as $category)
                                    <a href="{{route('search.businessCategorySearch', $category->slug)}}">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="saloonBanner">
                            <div class="row">
                                <div class="col-lg-4">
                                    <strong>Salonunuzun burada listelenmesini ister misiniz?
                                    </strong>
                                    <a href="{{env('remote_url')}}" target="_blank">Salonumu Listele</a>
                                </div>
                            </div>
                            <div class="bannerUser">
                                <img src="/assets/images/bannerUser.png" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="pageTab">
                            <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link active"
                                        id="pills-1-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#pills-1"
                                        type="button"
                                        role="tab"
                                        aria-controls="pills-1"
                                        aria-selected="true"
                                    >
                                        Salonlar
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link"
                                        id="pills-2-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#pills-2"
                                        type="button"
                                        role="tab"
                                        aria-controls="pills-2"
                                        aria-selected="false"
                                    >
                                        Kampanyalar
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div
                                    class="tab-pane fade show active"
                                    id="pills-1"
                                    role="tabpanel"
                                    aria-labelledby="pills-home-tab"
                                    tabindex="0"
                                >
                                    <div class="saloonList">
                                        <div class="row">
                                            @forelse($businesses as $business)
                                                @include('layouts.components.business')
                                            @empty
                                                <div class="alert alert-warning">
                                                    Aradığınız türde işletme kaydı bulunamadı
                                                </div>
                                            @endforelse
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            {!! $businesses->links() !!}
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="tab-pane fade"
                                    id="pills-2"
                                    role="tabpanel"
                                    aria-labelledby="pills-profile-tab"
                                    tabindex="0"
                                >
                                    ...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
