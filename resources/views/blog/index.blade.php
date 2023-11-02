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
                                <li class="breadcrumb-item active" aria-current="page">
                                    Blog Yazıları
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section id="bigSlider" class="mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="bigSliderContent">
                            <div class="owl-carousel owl-theme">
                                <div class="item">
                                    <a href="javascript:;">
                                        <img src="assets/images/bigSlider.png" alt="" />
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="javascript:;">
                                        <img src="assets/images/bigSlider.png" alt="" />
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="javascript:;">
                                        <img src="assets/images/bigSlider.png" alt="" />
                                    </a>
                                </div>
                            </div>
                            <div class="sliderArrow">
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
            </div>
        </section>
        <section id="pageContent">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="pageTitle mb-5">Blog Yazıları</h2>
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
                                        Saç Bakımı
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
                                        Tırnak Bakımı
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link"
                                        id="pills-3-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#pills-3"
                                        type="button"
                                        role="tab"
                                        aria-controls="pills-3"
                                        aria-selected="false"
                                    >
                                        Yüz Bakım
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
                                    <div class="blogList">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="blogListItem">
                                                    <div class="blogLıstItemPhoto">
                                                        <a href="javascript:;">
                                                            <img src="assets/images/blogitem.png" alt="" />
                                                        </a>
                                                        <a href="javascript:;" class="tag">Saç Bakımı</a>
                                                    </div>
                                                    <div class="blogLıstItemText">
                                                        <i>08.08.2021</i>
                                                        <a href="javascript:;">
                                                            Fusce diam ultricies magna senectus.
                                                        </a>
                                                        <span
                                                        >Pretium posuere diam morbi pellentesque vitae
                                blandit. Diam viverra fringilla nisi vel nunc
                                quis ipsum nisi pellentesque.
                                Pellentesque.</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="blogListItem">
                                                    <div class="blogLıstItemPhoto">
                                                        <a href="javascript:;">
                                                            <img src="assets/images/blogitem.png" alt="" />
                                                        </a>
                                                        <a href="javascript:;" class="tag">Saç Bakımı</a>
                                                    </div>
                                                    <div class="blogLıstItemText">
                                                        <i>08.08.2021</i>
                                                        <a href="javascript:;">
                                                            Fusce diam ultricies magna senectus.
                                                        </a>
                                                        <span
                                                        >Pretium posuere diam morbi pellentesque vitae
                                blandit. Diam viverra fringilla nisi vel nunc
                                quis ipsum nisi pellentesque.
                                Pellentesque.</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="blogListItem">
                                                    <div class="blogLıstItemPhoto">
                                                        <a href="javascript:;">
                                                            <img src="assets/images/blogitem.png" alt="" />
                                                        </a>
                                                        <a href="javascript:;" class="tag">Saç Bakımı</a>
                                                    </div>
                                                    <div class="blogLıstItemText">
                                                        <i>08.08.2021</i>
                                                        <a href="javascript:;">
                                                            Fusce diam ultricies magna senectus.
                                                        </a>
                                                        <span
                                                        >Pretium posuere diam morbi pellentesque vitae
                                blandit. Diam viverra fringilla nisi vel nunc
                                quis ipsum nisi pellentesque.
                                Pellentesque.</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="blogListItem">
                                                    <div class="blogLıstItemPhoto">
                                                        <a href="javascript:;">
                                                            <img src="assets/images/blogitem.png" alt="" />
                                                        </a>
                                                        <a href="javascript:;" class="tag">Saç Bakımı</a>
                                                    </div>
                                                    <div class="blogLıstItemText">
                                                        <i>08.08.2021</i>
                                                        <a href="javascript:;">
                                                            Fusce diam ultricies magna senectus.
                                                        </a>
                                                        <span
                                                        >Pretium posuere diam morbi pellentesque vitae
                                blandit. Diam viverra fringilla nisi vel nunc
                                quis ipsum nisi pellentesque.
                                Pellentesque.</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="blogListItem">
                                                    <div class="blogLıstItemPhoto">
                                                        <a href="javascript:;">
                                                            <img src="assets/images/blogitem.png" alt="" />
                                                        </a>
                                                        <a href="javascript:;" class="tag">Saç Bakımı</a>
                                                    </div>
                                                    <div class="blogLıstItemText">
                                                        <i>08.08.2021</i>
                                                        <a href="javascript:;">
                                                            Fusce diam ultricies magna senectus.
                                                        </a>
                                                        <span
                                                        >Pretium posuere diam morbi pellentesque vitae
                                blandit. Diam viverra fringilla nisi vel nunc
                                quis ipsum nisi pellentesque.
                                Pellentesque.</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="blogListItem">
                                                    <div class="blogLıstItemPhoto">
                                                        <a href="javascript:;">
                                                            <img src="assets/images/blogitem.png" alt="" />
                                                        </a>
                                                        <a href="javascript:;" class="tag">Saç Bakımı</a>
                                                    </div>
                                                    <div class="blogLıstItemText">
                                                        <i>08.08.2021</i>
                                                        <a href="javascript:;">
                                                            Fusce diam ultricies magna senectus.
                                                        </a>
                                                        <span
                                                        >Pretium posuere diam morbi pellentesque vitae
                                blandit. Diam viverra fringilla nisi vel nunc
                                quis ipsum nisi pellentesque.
                                Pellentesque.</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="blogListItem">
                                                    <div class="blogLıstItemPhoto">
                                                        <a href="javascript:;">
                                                            <img src="assets/images/blogitem.png" alt="" />
                                                        </a>
                                                        <a href="javascript:;" class="tag">Saç Bakımı</a>
                                                    </div>
                                                    <div class="blogLıstItemText">
                                                        <i>08.08.2021</i>
                                                        <a href="javascript:;">
                                                            Fusce diam ultricies magna senectus.
                                                        </a>
                                                        <span
                                                        >Pretium posuere diam morbi pellentesque vitae
                                blandit. Diam viverra fringilla nisi vel nunc
                                quis ipsum nisi pellentesque.
                                Pellentesque.</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="blogListItem">
                                                    <div class="blogLıstItemPhoto">
                                                        <a href="javascript:;">
                                                            <img src="assets/images/blogitem.png" alt="" />
                                                        </a>
                                                        <a href="javascript:;" class="tag">Saç Bakımı</a>
                                                    </div>
                                                    <div class="blogLıstItemText">
                                                        <i>08.08.2021</i>
                                                        <a href="javascript:;">
                                                            Fusce diam ultricies magna senectus.
                                                        </a>
                                                        <span
                                                        >Pretium posuere diam morbi pellentesque vitae
                                blandit. Diam viverra fringilla nisi vel nunc
                                quis ipsum nisi pellentesque.
                                Pellentesque.</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
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
                                <div
                                    class="tab-pane fade"
                                    id="pills-3"
                                    role="tabpanel"
                                    aria-labelledby="pills-contact-tab"
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

@section('scripts')

@endsection
