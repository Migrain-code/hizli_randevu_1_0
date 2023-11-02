@extends('layouts.master')
@section('title', 'Anasayfa')
@section('description', 'Description')
@section('content')
    <article>
        <section id="homeBanner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 d-flex align-items-end order-2 order-lg-1">
                        <div id="topSearchFilter">
                <span>
                  {{main('speed_main_page_small_title')}}
                  <strong> {{main('speed_main_page_big_title')}} </strong>
                </span>
                            <div class="topSearchFilterContent">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button
                                            class="nav-link active"
                                            id="pills-hizmet-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#pills-hizmet"
                                            type="button"
                                            role="tab"
                                            aria-controls="pills-hizmet"
                                            aria-selected="true"
                                        >
                                            Hizmet
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button
                                            class="nav-link"
                                            id="pills-salonturu-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#pills-salonturu"
                                            type="button"
                                            role="tab"
                                            aria-controls="pills-salonturu"
                                            aria-selected="false"
                                        >
                                            Salon Türü
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button
                                            class="nav-link"
                                            id="pills-salonadi-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#pills-salonadi"
                                            type="button"
                                            role="tab"
                                            aria-controls="pills-salonadi"
                                            aria-selected="false"
                                        >
                                            Salon Adı
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div
                                        class="tab-pane fade show active"
                                        id="pills-hizmet"
                                        role="tabpanel"
                                        aria-labelledby="pills-hizmet-tab"
                                        tabindex="0"
                                    >
                                        <form method="post" id="serviceSearch">
                                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                                                    <div class="customSelect iconSelect servicesSelect customTomSelect mb-4 mb-md-0">
                                                        <select class="tomSelect">
                                                            <option>Hizmet Seçiniz</option>
                                                            <option>Hizmet Seçiniz2</option>
                                                            <option>Hizmet Seçiniz3</option>
                                                            <option>Hizmet Seçiniz4</option>
                                                            <option>Hizmet Seçiniz5</option>
                                                            <option>Hizmet Seçiniz6</option>
                                                        </select>
                                                    </div>
                                                    <div class="customSelect iconSelect citySelect customTomSelect mb-4 mb-md-0">
                                                        <select class="tomSelect">
                                                            <option>Şehir Seçiniz</option>
                                                            <option>Şehir Seçiniz2</option>
                                                            <option>Şehir Seçiniz3</option>
                                                            <option>Şehir Seçiniz4</option>
                                                            <option>Şehir Seçiniz5</option>
                                                        </select>
                                                    </div>
                                                    <a href="#" onclick="$('#serviceSearch').submit()" class="btn-pink btn-rounded">
                                                        <svg
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
                                    <div
                                        class="tab-pane fade"
                                        id="pills-salonturu"
                                        role="tabpanel"
                                        aria-labelledby="pills-salonturu-tab"
                                        tabindex="0">
                                        <form method="post" id="categorySearch">
                                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                                                <div class="customSelect iconSelect servicesSelect customTomSelect mb-4 mb-md-0">
                                                    <select class="tomSelect">
                                                        <option>Hizmet Seçiniz</option>
                                                        <option>Hizmet Seçiniz2</option>
                                                        <option>Hizmet Seçiniz3</option>
                                                        <option>Hizmet Seçiniz4</option>
                                                        <option>Hizmet Seçiniz5</option>
                                                        <option>Hizmet Seçiniz6</option>
                                                    </select>
                                                </div>
                                                <div class="customSelect iconSelect citySelect customTomSelect mb-4 mb-md-0">
                                                    <select class="tomSelect">
                                                        <option>Şehir Seçiniz</option>
                                                        <option>Şehir Seçiniz2</option>
                                                        <option>Şehir Seçiniz3</option>
                                                        <option>Şehir Seçiniz4</option>
                                                        <option>Şehir Seçiniz5</option>
                                                    </select>
                                                </div>
                                                <a href="#" onclick="$('#serviceSearch').submit()" class="btn-pink btn-rounded">
                                                    <svg
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
                                    <div
                                        class="tab-pane fade"
                                        id="pills-salonadi"
                                        role="tabpanel"
                                        aria-labelledby="pills-salonadi-tab"
                                        tabindex="0"
                                    >
                                        <div class="customSelect iconSelect servicesSelect customTomSelect mb-4 mb-md-0">
                                            <select class="tomSelect">
                                                <option>Salon Adı</option>
                                                <option>Hizmet Seçiniz2</option>
                                                <option>Hizmet Seçiniz3</option>
                                                <option>Hizmet Seçiniz4</option>
                                                <option>Hizmet Seçiniz5</option>
                                                <option>Hizmet Seçiniz6</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 order-1 order-lg-2">
                        <div id="homeBannerSlider">
                            <div class="owl-carousel owl-theme">
                                @foreach($ads as $adHeader)
                                    <div class="item">
                                        <div class="photo">
                                            <img src="/assets/images/topbanner.png" alt="" />
                                        </div>
                                        <div class="text">
                                            <strong>{{$adHeader->title}}</strong>
                                            <p>

                                            </p>
                                            <a href="{{$adHeader->link}}" target="_blank"
                                            >Ziyaret Et
                                                <svg
                                                    width="10"
                                                    height="18"
                                                    viewBox="0 0 10 18"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M1.02734 1.72949L8.52734 9.22949L1.02734 16.7295"
                                                        stroke="#43506E"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="brandList">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="brandListSlider">
                            <div class="owl-carousel owl-theme">
                                @foreach($ads as $adBrand)
                                    <div class="item">
                                        <a href="{{$adBrand->link}}" target="_blank">
                                            <img src="/assets/images/brands/zara.svg" alt="" />
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <a href="javascript:;" class="sliderPrev">
                                <img src="assets/images/icons/ico-slider-left.svg" />
                            </a>
                            <a href="javascript:;" class="sliderNext">
                                <img src="assets/images/icons/ico-slider-right.svg" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="featuredServices">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="featuredTitle">Öne Çıkan Hizmetler</div>
                    </div>
                </div>
                <div class="row">
                    <div class="featuredLinks d-flex align-items-center flex-wrap">
                        @foreach($featuredServices as $service)
                            <a href="{{route('search.service', $service->slug)}}">
                                <img src="assets/images/icons/ico-links-1.svg" alt="" />
                                <span>{{$service->name}}</span>
                            </a>
                        @endforeach

                    </div>
                </div>
                <div class="row featuredBox">
                    <div class="col-lg-4">
                        <div class="featuredBoxItem">
                            <div class="icon">
                                <img src="assets/images/icons/ico-search-2.svg" alt="" />
                            </div>
                            <strong>Salonları Arayın</strong>
                            <span
                            >Binlerce salon arasından arama yapın, size en uygun hizmet
                  veren yerleri bulun ve randevunuzu hemen kolayca alın.</span
                            >
                            <a href="javascript:;">
                                Salon Ara
                                <svg
                                    width="10"
                                    height="17"
                                    viewBox="0 0 10 17"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M1.2998 0.931641L8.7998 8.43164L1.2998 15.9316"
                                        stroke="#43506E"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="featuredBoxItem">
                            <div class="icon">
                                <img src="assets/images/icons/ico-search-2.svg" alt="" />
                            </div>
                            <strong>Salonları Arayın</strong>
                            <span
                            >Binlerce salon arasından arama yapın, size en uygun hizmet
                  veren yerleri bulun ve randevunuzu hemen kolayca alın.</span
                            >
                            <a href="javascript:;">
                                Salon Ara
                                <svg
                                    width="10"
                                    height="17"
                                    viewBox="0 0 10 17"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M1.2998 0.931641L8.7998 8.43164L1.2998 15.9316"
                                        stroke="#43506E"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="featuredBoxItem">
                            <div class="icon">
                                <img src="assets/images/icons/ico-search-2.svg" alt="" />
                            </div>
                            <strong>Salonları Arayın</strong>
                            <span
                            >Binlerce salon arasından arama yapın, size en uygun hizmet
                  veren yerleri bulun ve randevunuzu hemen kolayca alın.</span
                            >
                            <a href="javascript:;">
                                Salon Ara
                                <svg
                                    width="10"
                                    height="17"
                                    viewBox="0 0 10 17"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M1.2998 0.931641L8.7998 8.43164L1.2998 15.9316"
                                        stroke="#43506E"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="sallonType">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="d-flex flex-column h-100">
                            <div class="title">
                                <strong>Salon</strong>
                                <span>Türleri</span>
                            </div>
                            <p class="my-auto">
                                Blandit convallis lectus lacus lobortis. In nibh gravida
                                porttitor pulvinar. Nulla mauris risus vitae dictumst.
                            </p>
                            <div class="mt-auto">
                                <a href="javascript:;" class="btn-pink btn-rounded">
                                    Tümünü Gör
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div id="sallonTypeSlider">
                            <div
                                class="panels d-flex align-items-center justify-content-end"
                            >

                                @foreach($categories as $category)
                                    @if($loop->index < 5)
                                        <div
                                            class="panel active"
                                            style="
                                          background-image: url(/assets/images/sallontype.jpg);
                                        "
                                        >
                                            <div
                                                class="text d-flex align-items-center justify-content-between"
                                            >
                                                <strong>{{$category->name}}</strong>
                                                <a href="javascript:;"
                                                ><svg
                                                        width="20"
                                                        height="15"
                                                        viewBox="0 0 20 15"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M1.0498 7.41895L19.0441 7.41895"
                                                            stroke="white"
                                                            stroke-width="1.74405"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                        />
                                                        <path
                                                            d="M12.9395 13.5233L19.0436 7.41913L12.9395 1.31494"
                                                            stroke="white"
                                                            stroke-width="1.74405"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                        />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="studiosTab">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs" id="studiosTabHeader" role="tablist">
                            @forelse($featuredCategories as $fCategory)
                                <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link @if($loop->first) active @endif"
                                    id="home-tab1"
                                    data-bs-toggle="tab"
                                    data-bs-target="#home-tab{{$fCategory->id}}-pane"
                                    type="button"
                                    role="tab"
                                    aria-controls="home-tab{{$fCategory->id}}-pane"
                                    aria-selected="true"
                                >
                                    {{$fCategory->category->name}}
                                </button>
                            </li>
                            @empty
                            @endforelse

                        </ul>
                        <div class="tab-content" id="studiosTabContent">
                            @forelse($featuredCategories as $fCategory)
                            <div
                                class="tab-pane fade show active"
                                id="home-tab{{$fCategory->id}}-pane"
                                role="tabpanel"
                                aria-labelledby="home-tab{{$fCategory->id}}"
                                tabindex="0"
                            >
                                <div class="row">
                                    @foreach($fCategory->cities as $city)
                                        <div class="col-sm-6 col-lg-4">
                                            <a href="javascript:;">{{$city->city->name}} {{$fCategory->category->name}}</a>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="homeEvents">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="homeEventsTitle">
                            <strong>Etkinliklerimiz Hakkında</strong>
                            Daha Fazla Bİlgi Edinin
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-lg-row">
                    <div class="homeEventsList">
                        <a href="javascript:;" class="d-flex align-items-center">
                <span class="date">
                  <strong>01</strong>
                  <span>Ocak</span>
                  <span>2023</span>
                </span>
                            <span class="text"
                            >Consequat risus mollis morbi quam nunc turpis. Amet donec
                  vestibulum enim cras.</span
                            >
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center">
                <span class="date">
                  <strong>01</strong>
                  <span>Ocak</span>
                  <span>2023</span>
                </span>
                            <span class="text"
                            >Consequat risus mollis morbi quam nunc turpis. Amet donec
                  vestibulum enim cras.</span
                            >
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center">
                <span class="date">
                  <strong>01</strong>
                  <span>Ocak</span>
                  <span>2023</span>
                </span>
                            <span class="text"
                            >Consequat risus mollis morbi quam nunc turpis. Amet donec
                  vestibulum enim cras.</span
                            >
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center">
                <span class="date">
                  <strong>01</strong>
                  <span>Ocak</span>
                  <span>2023</span>
                </span>
                            <span class="text"
                            >Consequat risus mollis morbi quam nunc turpis. Amet donec
                  vestibulum enim cras.</span
                            >
                        </a>
                    </div>
                    <div id="eventDatePicker"></div>
                </div>
            </div>
        </section>
        <section id="homeBlog">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="homeBlogLeft">
                            <div class="homeBlogTitle">
                                <strong>Blog</strong>
                                Yazılarımız
                            </div>
                            <p>
                                Hac mollis viverra ornare enim enim lectus. Velit justo quam
                                iaculis risus facilisis auctor in.
                            </p>
                            <div
                                id="customBlogSliderNav"
                                class="owl-nav d-flex align-items-center my-5"
                            ></div>
                            <a href="{{route('blog.index')}}" class="btn-pink btn-rounded"
                            >Tümünü Gör</a
                            >
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="homeBlogSlider">
                            <div class="owl-carousel owl-theme">
                                @foreach($blogs as $blog)
                                    <div class="item">
                                        <div class="blogSliderItem">
                                            <div class="blogSliderPhoto">
                                                <img src="/assets/images/blogslider.png" alt="" />
                                            </div>
                                            <div class="blogSliderText">
                                                <strong>{{$blog->title}}.</strong>
                                                <a href="javascript:;">
                                                    <span>Daha Fazla Bilgi</span>
                                                    <svg
                                                        width="12"
                                                        height="12"
                                                        viewBox="0 0 12 12"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <g opacity="0.5">
                                                            <path
                                                                d="M0.767578 5.75024L11.0266 5.75024"
                                                                stroke="#26265C"
                                                                stroke-width="1.09918"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                            <path
                                                                d="M5.89746 0.620658L11.027 5.75015L5.89746 10.8796"
                                                                stroke="#26265C"
                                                                stroke-width="1.09918"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                        </g>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
