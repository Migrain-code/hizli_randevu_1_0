@extends('layouts.master')
@section('title', $blog->getTitle())
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
                                <li class="breadcrumb-item">
                                    <a href="{{route('blog.index')}}">Blog Yazıları</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{$blog->getTitle()}}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <section id="pageContent">
                        <div class="row mb-5">
                            <div class="col-12 border-end">
                                <div class="pe-md-4">
                                    <div class="pageBanner mb-5">
                                        <img
                                            src="{{image($blog->image)}}"
                                            class="w-100"
                                            alt=""
                                        />
                                    </div>
                                    @if(count($heads) > 0)
                                        <div class="moreContent">
                                            <a href="javascript:;" class="moreContentLink"
                                            >İçerikleri Göster</a
                                            >
                                            <div class="moreContentList">
                                                <div class="row">
                                                    @forelse($heads as $head)
                                                        <div class="col-lg-4">
                                                            <a href="#head-{{$loop->index}}">{{$head}} </a>
                                                        </div>
                                                    @empty
                                                    @endforelse


                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <h2 class="pageTitle mb-5">
                                       {{$blog->title}}
                                    </h2>
                                    <div class="pageText">
                                        {!! $blog->getDescription() !!}
                                    </div>
                                    @if($blog->social)
                                        <div class="socialShare d-flex align-items-center my-4">
                                            @if($blog->social->facebook)
                                                <a href="{{$blog->social->facebook}}" target="_blank">
                                                    <svg
                                                        width="14"
                                                        height="25"
                                                        viewBox="0 0 14 25"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M9.12266 14.1892H12.1227L13.3227 9.38916H9.12266V6.98916C9.12266 5.75316 9.12266 4.58916 11.5227 4.58916H13.3227V0.55716C12.9315 0.50556 11.4543 0.38916 9.89426 0.38916C6.63626 0.38916 4.32266 2.37756 4.32266 6.02916V9.38916H0.722656V14.1892H4.32266V24.3892H9.12266V14.1892Z"
                                                            fill="#43506E"
                                                        />
                                                    </svg>
                                                </a>
                                            @endif
                                            @if($blog->social->twitter)
                                                <a href="{{$blog->social->twitter}}" target="_blank">
                                                    <svg
                                                        width="26"
                                                        height="22"
                                                        viewBox="0 0 26 22"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M8.29689 21.017C17.8772 21.017 23.118 13.0789 23.118 6.20701C23.118 5.98487 23.118 5.75956 23.1085 5.53743C24.1288 4.79881 25.0094 3.88436 25.709 2.83691C24.756 3.25714 23.746 3.5341 22.7118 3.65881C23.8011 3.0077 24.617 1.98323 25.0077 0.775822C23.9843 1.38213 22.8642 1.80775 21.6963 2.03405C20.9112 1.19791 19.8723 0.643997 18.7405 0.458102C17.6087 0.272207 16.4472 0.464709 15.4359 1.00579C14.4246 1.54687 13.6199 2.40633 13.1465 3.45105C12.6731 4.49576 12.5574 5.66743 12.8173 6.78456C10.7463 6.68071 8.72024 6.14269 6.87054 5.20541C5.02083 4.26812 3.38881 2.95249 2.0803 1.34385C1.41602 2.49115 1.2133 3.84826 1.5133 5.1396C1.81329 6.43093 2.59352 7.55969 3.69553 8.29665C2.86973 8.2686 2.06209 8.04685 1.33774 7.64929V7.72069C1.33916 8.92257 1.75552 10.0871 2.51644 11.0174C3.27735 11.9477 4.33615 12.5868 5.51386 12.8266C5.06684 12.9498 4.60506 13.0111 4.14139 13.0091C3.81451 13.0101 3.48828 12.9798 3.16717 12.9186C3.50003 13.9532 4.14817 14.8578 5.0208 15.5057C5.89343 16.1535 6.94684 16.5122 8.0335 16.5315C6.18749 17.9814 3.9072 18.7678 1.55987 18.7639C1.14626 18.7657 0.732933 18.7418 0.322266 18.6925C2.70468 20.2114 5.47149 21.0179 8.29689 21.017Z"
                                                            fill="#43506E"
                                                        />
                                                    </svg>
                                                </a>
                                            @endif
                                            @if($blog->social->linkedin)
                                                <a href="{{$blog->social->linkedin}}" target="_blank">
                                                    <svg
                                                        width="31"
                                                        height="30"
                                                        viewBox="0 0 31 30"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M7.00489 4.03869C7.00448 4.87358 6.67242 5.67411 6.08177 6.26417C5.49111 6.85423 4.69025 7.18549 3.85536 7.18507C3.02048 7.18465 2.21995 6.85259 1.62989 6.26194C1.03983 5.67129 0.708567 4.87043 0.708985 4.03554C0.709402 3.20065 1.04146 2.40012 1.63211 1.81006C2.22276 1.22 3.02362 0.888743 3.85851 0.889161C4.6934 0.889578 5.49393 1.22164 6.08399 1.81229C6.67405 2.40294 7.00531 3.2038 7.00489 4.03869ZM7.09933 9.51613H0.803423V29.2223H7.09933V9.51613ZM17.0469 9.51613H10.7824V29.2223H16.9839V18.8813C16.9839 13.1205 24.4918 12.5854 24.4918 18.8813V29.2223H30.709V16.7407C30.709 7.02924 19.5967 7.39126 16.9839 12.1604L17.0469 9.51613Z"
                                                            fill="#43506E"
                                                        />
                                                    </svg>
                                                </a>
                                            @endif
                                            @if($blog->social->youtube)
                                                <a href="{{$blog->social->youtube}}" target="_blank">
                                                    <svg
                                                        width="30"
                                                        height="21"
                                                        viewBox="0 0 30 21"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M29.2971 3.58589C29.1309 2.96687 28.805 2.40237 28.3521 1.94886C27.8991 1.49536 27.335 1.16878 26.7162 1.00179C24.4384 0.38916 15.3077 0.38916 15.3077 0.38916C15.3077 0.38916 6.17699 0.38916 3.8992 0.998527C3.28012 1.16497 2.71574 1.49138 2.26272 1.94497C1.80971 2.39855 1.48402 2.96335 1.31835 3.58263C0.708984 5.86368 0.708984 10.6213 0.708984 10.6213C0.708984 10.6213 0.708984 15.3789 1.31835 17.6567C1.65399 18.9146 2.64462 19.9052 3.8992 20.2408C6.17699 20.8534 15.3077 20.8534 15.3077 20.8534C15.3077 20.8534 24.4384 20.8534 26.7162 20.2408C27.9741 19.9052 28.9614 18.9146 29.2971 17.6567C29.9064 15.3789 29.9064 10.6213 29.9064 10.6213C29.9064 10.6213 29.9064 5.86368 29.2971 3.58589ZM12.4075 14.9879V6.25472L19.9676 10.5887L12.4075 14.9879Z"
                                                            fill="#43506E"
                                                        />
                                                    </svg>
                                                </a>
                                            @endif
                                            @if($blog->social->instagram)
                                                <a href="{{$blog->social->instagram}}" target="_blank">
                                                    <svg
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M12.1562 8.38916C11.1617 8.38916 10.2079 8.78425 9.5046 9.48751C8.80134 10.1908 8.40625 11.1446 8.40625 12.1392C8.40625 13.1337 8.80134 14.0875 9.5046 14.7908C10.2079 15.4941 11.1617 15.8892 12.1562 15.8892C13.1508 15.8892 14.1046 15.4941 14.8079 14.7908C15.5112 14.0875 15.9062 13.1337 15.9062 12.1392C15.9062 11.1446 15.5112 10.1908 14.8079 9.48751C14.1046 8.78425 13.1508 8.38916 12.1562 8.38916Z"
                                                            fill="#43506E"
                                                        />
                                                        <path
                                                            fill-rule="evenodd"
                                                            clip-rule="evenodd"
                                                            d="M7.65625 0.88916C5.86604 0.88916 4.14915 1.60032 2.88328 2.86619C1.61741 4.13206 0.90625 5.84895 0.90625 7.63916L0.90625 16.6392C0.90625 18.4294 1.61741 20.1463 2.88328 21.4121C4.14915 22.678 5.86604 23.3892 7.65625 23.3892H16.6562C18.4465 23.3892 20.1633 22.678 21.4292 21.4121C22.6951 20.1463 23.4062 18.4294 23.4062 16.6392V7.63916C23.4062 5.84895 22.6951 4.13206 21.4292 2.86619C20.1633 1.60032 18.4465 0.88916 16.6562 0.88916L7.65625 0.88916ZM6.90625 12.1392C6.90625 10.7468 7.45937 9.41142 8.44394 8.42685C9.42851 7.44228 10.7639 6.88916 12.1562 6.88916C13.5486 6.88916 14.884 7.44228 15.8686 8.42685C16.8531 9.41142 17.4062 10.7468 17.4062 12.1392C17.4062 13.5315 16.8531 14.8669 15.8686 15.8515C14.884 16.836 13.5486 17.3892 12.1562 17.3892C10.7639 17.3892 9.42851 16.836 8.44394 15.8515C7.45937 14.8669 6.90625 13.5315 6.90625 12.1392ZM17.4062 6.88916H18.9062V5.38916H17.4062V6.88916Z"
                                                            fill="#43506E"
                                                        />
                                                    </svg>
                                                </a>
                                            @endif

                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-3">
                    <aside class="ps-4">
                        <div class="widgetBox mb-5">
                            <div class="widgetTitle">Daha fazlasını keşfedin</div>
                            <div class="discoverLinks">
                                @foreach($blogCategories as $category)
                                    <a href="{{route('blog.category', $category->getSlug())}}">{{$category->getName()}}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="widgetBox mb-5">
                            <div class="widgetTitle">En Çok Okunanlar</div>
                            <div class="populerList">
                                @forelse($blog->category->blogs()->latest()->take(5)->get() as $blogRow)
                                    <a href="javascript:;">
                                    <span class="populerListPhoto">
                                      <img src="{{image($blogRow->image)}}" alt="" />
                                    </span>
                                        <span class="populerListText">
                                          <strong>
                                              {{$blogRow->getTitle()}}
                                          </strong>
                                          <p>
                                            {{\Illuminate\Support\Str::limit(strip_tags($blogRow->getDescription()), 100)}}
                                          </p>
                                        </span>
                                    </a>
                                @empty
                                @endforelse

                            </div>
                        </div>
                    </aside>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="pageSubTitle text-center mt-5 pt-5 mb-4">
                        Benzer Yazılar
                    </div>
                    <div class="blogListSlider">
                        <div class="owl-carousel owl-theme">
                            @forelse($blog->category->blogs()->take(5)->get() as $blogRow)
                                <div class="item">
                                    <div class="blogListItem">
                                        <div class="blogLıstItemPhoto">
                                            <a href="{{route('blog.detail', $blog->slug)}}">
                                                <img src="{{image($blog->image)}}" alt="" />
                                            </a>
                                            <a href="{{route('blog.category', $blog->category->getSlug())}}" class="tag">{{$blog->category->getName()}}</a>
                                        </div>
                                        <div class="blogLıstItemText">
                                            <i>{{$blog->created_at->format('d.m.Y')}}</i>
                                            <a href="{{route('blog.detail', $blog->slug)}}">
                                                {{$blog->getTitle()}}
                                            </a>
                                            <span>
                                                {{\Illuminate\Support\Str::limit(strip_tags($blog->getDescription()), 100)}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const hElements = document.querySelectorAll('h1, h2, h3, h4, h5');

            for (let i = 0; i < hElements.length; i++) {
                hElements[i].setAttribute('id', `head-${i}`);
            }
        });
    </script>
@endsection
