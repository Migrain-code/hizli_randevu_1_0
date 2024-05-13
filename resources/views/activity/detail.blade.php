@extends('layouts.master')
@section('title', $activity->meta_title)
@section('description', $activity->meta_description)
@section('styles')
    <style>
        iframe{
            border-radius: 25px;
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
                                <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                                <li class="breadcrumb-item">
                                    Etkinlikler
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    {{$activity->getTitle()}}
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
                                        <div id="carouselExample" class="carousel slide">
                                            <div class="carousel-inner">
                                                @foreach($activity->sliders as $slider)
                                                    <div class="carousel-item active">
                                                        <img src="{{image($slider->image)}}" class="d-block w-100" alt="...">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    </div>

                                    <h2 class="pageTitle mb-5">
                                        {{$activity->getTitle()}}
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
                                            <span>{{\Illuminate\Support\Carbon::parse($activity->start_time)->format('d.m.Y H:i')}}</span>
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
                                        {!! $activity->getDescription() !!}
                                    </div>

                                    @if($personels->count() > 0)
                                        <div class="eventsUsers">
                                            <div
                                                class="pageSubTitle mt-5 pt-5 pb-3 mb-4 border-bottom"
                                            >
                                                Kullanıcılar
                                            </div>
                                            <div class="js-photo-gallery">
                                                <div class="owl-carousel">
                                                    @foreach($personels as $personel)
                                                        <div class="item">
                                                            <div class="eventUserItem">
                                                                <div class="photo">
                                                                    <img src="{{image($personel->personel->image)}}" alt=""/>
                                                                    <span>{{$personel->personel->name}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($activity->sponsors->count() > 0)
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
                                    @endif

                                    <div class="eventVideos">
                                        <div class="pageSubTitle mt-5 pt-5 text-center">
                                            Video Galeri
                                        </div>
                                        <p class="pageDesc text-center mb-3">
                                        </p>

                                        <div class="video">
                                            <iframe width="100%" height="626"
                                                    src="{!! $activity->embed !!}"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen>
                                            </iframe>
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
                                      <img src="{{image($activity->sliders->first()->image)}}" alt=""/>
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
        @if($gallery->count() > 0)
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
                            @foreach($gallery as $row)
                            <div class="item">
                                <a
                                    href="{{image($row->image)}}"
                                    data-lightbox="image-1"
                                    data-title="Etkinlik Görseli - {{$loop->index}}"
                                >
                                    <img src="{{image($row->image)}}" alt="" />
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif
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
