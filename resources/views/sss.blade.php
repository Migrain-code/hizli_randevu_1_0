@extends('layouts.master')
@section('title', 'Destek')
@section('styles')
 <style>
     /**
 ** SSS
 */
     .sss-page {
     }

     .sss-page .hero {
         text-align: center;
     }

     .sss-page .hero h2 {
         color: #43506e;
         font-weight: 300;
     }

     .sss-page .hero h2 span {
         color: #43506e;
         font-weight: 500;
     }

     .sss-page .hero {
         font-weight: 300;
     }

     .sss-page .subhead {
         text-align: center;
     }

     .sss-page .subhead p {
         color: #43506e;
         font-weight: 300;
         font-size: 20px;
         opacity: 50%;
     }

     .sss-page .sss-categories {
         background: rgba(242, 41, 105, 0.06);
         padding: 48px 27px;
     }

     .sss-page .sss-categories .categories-hero {
         color: #f22969;
         font-size: 20px;
         font-weight: 500;
         margin-bottom: 20px;
         padding: 0 14px;
     }

     .sss-page .sss-categories ul {
         list-style: none;
         padding: 0;
     }

     .sss-page .sss-categories ul li {
         padding: 14px 0;
         color: #43506e;
         font-size: 16px;
         font-style: normal;
         font-weight: 300;
         line-height: normal;
         cursor: pointer;
         transition: all 0.3s ease-in-out;
     }

     .sss-page .sss-categories ul li span {
         padding: 20px 14px;
     }

     .sss-page .sss-categories ul li:hover {
         background-color: #f22969;
         color: #fff;
     }

     .sss-page .sss-categories ul li:not(:last-of-type) {
         border-bottom: 1px solid rgba(67, 80, 110, 0.15);
     }

     .sss-page .sss-content .faq-items .faq-item {
         background-color: #fff;
         padding: 24px 48px;
         cursor: pointer;
         margin-bottom: 20px;
     }

     .sss-page .sss-content .faq-items .faq-item .faq-head {
         display: flex;
         align-items: center;
         justify-content: space-between;
         color: #43506e;
         font-size: 18px;
     }

     .sss-page .sss-content .faq-items .faq-item.active .faq-head svg {
         transition: all 0.3s ease-in-out;
         transform: rotate(-180deg);
     }

     .sss-page .sss-content .faq-items .faq-item .faq-content {
         display: none;
         margin-top: 20px;
         border-top: 1px solid rgba(67, 80, 110, 0.15);
         padding: 24px 0;
     }

     .sss-page .sss-content .faq-items .faq-item .faq-content p {
         color: #43506e;
         font-family: Euclid Circular A;
         font-size: 16px;
         line-height: 28px;
         font-style: normal;
         font-weight: 400;
         opacity: 0.5;
     }

     .tab-content {
         display: none;
     }

     .tab-content.active {
         display: block;
     }

     @media (max-width: 992px) {
         .sss-page .sss-categories {
             margin-bottom: 20px;
         }
     }

 </style>
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
                                    Sıkça Sorulan Sorular
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section id="pageContent">
            <div class="container">
                <div class="sss-page">
                    <div class="row">
                        <div class="col-4 col-lg-3"></div>
                        <div class="col-8 col-lg-9">
                            <div class="hero">
                                <h2>
                                    <span>Sıkça Sorulan Sorular</span> <br />
                                    Bu sorulara cevaplarımız aşağda
                                </h2>
                            </div>
                            <div class="subhead">
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="sss-categories">
                                <div class="categories-hero">S.S.S Kategorileri</div>
                                <ul class="tabs">
                                    @foreach($categories as $category)
                                        <li class="tab @if($loop->first) active @endif" data-tab="tab{{$category->id}}">
                                            <span>{{$category->getName()}}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            @foreach($categories as $category)
                                <div class="tab-content @if($loop->first) active @endif" id="tab{{$category->id}}">
                                <div class="sss-tab1">
                                    <div class="sss-content">
                                        <div class="faq-items">
                                            @foreach($category->faqs as $faq)
                                                <div class="faq-item">
                                                    <div class="faq-head">
                                                        {{$faq->getQuestion()}}
                                                        <svg
                                                            width="18"
                                                            height="10"
                                                            viewBox="0 0 18 10"
                                                            fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                        >
                                                            <path
                                                                opacity="0.6"
                                                                d="M1 0.856445L6.5 6.1265L9.41413 8.85645L17 0.856445"
                                                                stroke="#43506E"
                                                                stroke-width="1.5"
                                                                stroke-miterlimit="10"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                            />
                                                        </svg>
                                                    </div>
                                                    <div class="faq-content">
                                                        <p>
                                                            {{$faq->getAnswer()}}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach


                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(".faq-item").click(function () {
                var faqContent = $(this).find(".faq-content");
                if (faqContent.is(":visible")) {
                    $(this).removeClass("active");
                    faqContent.slideUp();
                } else {
                    $(".faq-item").removeClass("active");
                    $(".faq-content").slideUp(); // Diğer .faq-content'leri kapat
                    $(this).addClass("active");
                    faqContent.slideDown();
                }
            });
        });

        // JQuery ile sekme geçişleri
        $(document).ready(function () {
            $(".tab").click(function () {
                var tabId = $(this).data("tab");
                $(".tab").removeClass("active");
                $(".tab-content").removeClass("active");
                $(this).addClass("active");
                $("#" + tabId).addClass("active");
            });
        });
    </script>
@endsection
