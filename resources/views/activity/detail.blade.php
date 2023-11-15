@extends('layouts.master')
@section('title', $activity->title)
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
                                <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                                <li class="breadcrumb-item">
                                    Etkinlikler
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    {{$activity->title}}
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
                                            src="{{image($activity->image)}}"
                                            class="w-100"
                                            alt=""
                                        />
                                    </div>

                                    <h2 class="pageTitle mb-5">
                                        {{$activity->title}}
                                    </h2>
                                    <div class="postMeta d-flex align-items-center flex-wrap">
                                        <div class="metaItem user d-flex align-items-center">
                                            <img src="/assets/images/blogitem.png" alt=""/>
                                            <span>Admin</span>
                                        </div>
                                        <div class="metaItem d-flex align-items-center">
                                            <img
                                                src="/assets/images/icons/ico-calendar.svg"
                                                alt=""
                                            />
                                            <span>{{$activity->start_date}}</span>
                                        </div>
                                        <div class="metaItem d-flex align-items-center">
                                            <img src="/assets/images/icons/ico-users.svg" alt=""/>
                                            <span>Katılımcı {{$activity->personels->count()}}</span>
                                        </div>
                                        <div class="metaItem d-flex align-items-center">
                                            <img src="/assets/images/icons/ico-healt.svg" alt=""/>
                                            <span>Sponsorlar {{$activity->sponsors->count()}}</span>
                                        </div>
                                        <a
                                            href="javascript:;" data-bs-toggle="modal" data-bs-target="#account_modal"
                                            class="btn-pink btn-rounded ms-md-4"
                                        >Etkinliğe Katıl</a>
                                    </div>
                                    <div class="pageText">
                                        {!! $activity->description !!}
                                    </div>
                                    <div class="socialShare d-flex align-items-center my-4">
                                        <a href="javascript:;">
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
                                        <a href="javscript:;">
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
                                        <a href="javscript:;">
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
                                        <a href="javscript:;">
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
                                        <a href="javscript:;">
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
                                    </div>
                                    <div class="eventsUsers">
                                        <div
                                            class="pageSubTitle mt-5 pt-5 pb-3 mb-4 border-bottom"
                                        >
                                            Kullanıcılar
                                        </div>
                                        <div class="js-photo-gallery">
                                            <div class="owl-carousel">
                                                @forelse($activity->personels as $personel)
                                                    <div class="item">
                                                        <div class="eventUserItem">
                                                            <div class="photo">
                                                                <img src="{{image($personel->image)}}" alt=""/>
                                                                <span>{{$personel->name}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty

                                                @endforelse

                                            </div>
                                        </div>
                                    </div>
                                    <div class="sponsorLogos">
                                        <div
                                            class="pageSubTitle mt-5 pt-5 pb-3 mb-4 border-bottom"
                                        >
                                            Sponsorlar
                                        </div>
                                        <div class="sponsorList">
                                            <div class="row">
                                                <div class="js-event-sponsor">
                                                    <div class="owl-carousel">
                                                        @forelse($activity->sponsors as $sponsor)
                                                            <div class="item">
                                                                <div class="sponsorItem">
                                                                    <div class="sponsorLogo">
                                                                        <img
                                                                            src="{{image($sponsor->image)}}"
                                                                            alt=""
                                                                        />
                                                                    </div>
                                                                    <i>
                                                                        @if($sponsor->status==1)
                                                                            Ana Sponsor
                                                                        @else
                                                                            {{$sponsor->text}}
                                                                        @endif
                                                                    </i>
                                                                    <a href="javascript:;">{{$sponsor->name}}</a>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="alert alert-warning d-flex align-items-center"
                                                                 role="alert">
                                                                <svg class="bi flex-shrink-0 me-2" role="img"
                                                                     aria-label="Warning:">
                                                                    <use xlink:href="#exclamation-triangle-fill"/>
                                                                </svg>
                                                                <div>
                                                                    Etkinlik Sponsoru Bulunamadı
                                                                </div>
                                                            </div>
                                                        @endforelse


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="eventVideos">
                                        <div class="pageSubTitle mt-5 pt-5 text-center">
                                            Video Galeri
                                        </div>
                                        <p class="pageDesc text-center mb-3">
                                        </p>
                                        <div class="video">
                                            <img src="/assets/images/video.png" alt=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-3">
                    <aside class="ps-4">
                        <div class="widgetBox mb-5">
                            <div class="widgetTitle">Yeni Etkinlikler</div>
                            <div class="populerList">
                                @forelse($latestActivities as $activity)
                                    <a href="{{route('activity.detail', $activity->slug)}}">
                                    <span class="populerListPhoto">
                                      <img src="{{image($activity->image)}}" alt=""/>
                                    </span>
                                        <span class="populerListText">
                                      <strong>{{$activity->title}}</strong>
                                      <p>
                                        {{\Illuminate\Support\Str::limit(strip_tags($activity->description), 100)}}
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
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="pageSubTitle mb-2">
                        <strong>Fotoğraf</strong>
                        <span>Arşivi</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="js-photo-gallery">
                        <div class="owl-carousel">
                            @forelse($activity->images as $gallery)
                                <div class="item">
                                    <a
                                        href="/assets/images/saloonCustomerPhoto.png"
                                        data-lightbox="image-1"
                                        data-title="My caption"
                                    >
                                        <img src="{{image($gallery->image)}}" alt=""/>
                                    </a>
                                </div>
                            @empty
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </article>
    <div class="modal fade custom-modal" id="account_modal" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="
                                                                                    width: 24px;
                                                                                    margin-right: 0px;
                                                                                    height: 24px;
                                                                                    border-radius: 50%;
                                                                                    padding: 5px;
                                                                                    background: #d6d6d6;
                                                                                    position: absolute;
                                                                                    right: 17px;
                                                                                    top: 12px;">
                        <i class="fa fa-times"></i>
                    </button>
                    <div class="mb-5"><h5> Lütfen personel bilgilerinizi doğrulayın </h5></div>

                    <form id="accounts_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Telefon</label>
                                    <input type="text" id="phone" class="form-control branch_name phone" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-1">
                                <div class="form-group">
                                    <label class="control-label">Şifre</label>
                                    <input type="password" id="password" class="form-control" autocomplete="false"
                                           value="">

                                </div>
                            </div>
                        </div>


                        <div class="modal-footer text-center">
                            <a type="button" id="acc_btn" class="btn-pink">Bilgilerimi Doğrula</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#acc_btn').on('click', function () {
            $.ajax({
                url: "{{route('activity.personel.control')}}",
                type: "POST",
                data: {
                    '_token': '{{csrf_token()}}',
                    'activity_id': '{{$activity->id}}',
                    'phone': $('#phone').val(),
                    'password': $('#password').val(),
                },
                dataType: 'JSON',
                success: function (res) {
                    if (res.status == "success") {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            })
        });

    </script>
@endsection
