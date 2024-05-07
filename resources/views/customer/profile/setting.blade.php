@extends('layouts.master')
@section('title', "Ayarlarım")
@section('meta_description', "Kullanıcı Profilim")
@section('styles')

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
                                    Ayarlar
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
                                <form class="profileSettings" method="post" action="{{route('customer.profile.update')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-5 d-flex justify-content-center">
                                        <div class="userPhotoEdit">
                                            <input type="file" name="image"/>
                                            <div class="photo">
                                                <img src="{{image(auth()->user()->image)}}" alt="" />
                                            </div>
                                            <span
                                            ><img src="/assets/images/icons/ico-edit.svg"
                                                /></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="floatingInput"
                                                    placeholder="Ad"
                                                    name="name"
                                                    value="{{auth()->user()->name}}"
                                                />
                                                <label for="floatingInput">Ad Soyad</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="floatingInput"
                                                    placeholder="Telefon"
                                                    name="phone"
                                                    value="{{auth()->user()->phone}}"
                                                />
                                                <label for="floatingInput">Telefon</label>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <div class="customSelect customTomSelect">
                                                            <select class="tomSelect" name="day">
                                                                <option selected disabled>Gün</option>
                                                                @for($i = 1; $i < 31 ; $i++ )
                                                                    <option value="{{$i}}" @selected(auth()->user()->birthday ? \Illuminate\Support\Carbon::parse(auth()->user()->birthday)->day == $i : false)>{{$i}}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <div class="customSelect customTomSelect">
                                                            <select class="tomSelect" name="month">
                                                                <option selected disabled>Ay</option>
                                                                @for($i = 1; $i <= 12 ; $i++ )
                                                                    <option value="{{$i}}" @selected(auth()->user()->birthday ? \Illuminate\Support\Carbon::parse(auth()->user()->birthday)->month == $i : false)>{{\Illuminate\Support\Carbon::createFromDate(2023, $i)->translatedFormat('F')}}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <div class="customSelect customTomSelect">
                                                            <select class="tomSelect" name="year">
                                                                <option selected disabled>Yıl</option>
                                                                @for ($i = now()->year; $i >= 1940; $i--)
                                                                    <option value="{{ $i }}" @selected(auth()->user()->birthday ? \Illuminate\Support\Carbon::parse(auth()->user()->birthday)->year == $i : false)>{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            @dd($allCities->count())
                                            <div class="mb-3">
                                                <div class="customSelect customTomSelect">
                                                    <select class="tomSelect" name="city_id" id="city_select">
                                                        <option selected>İl</option>
                                                        @foreach($allCities as $city)
                                                            <option value="{{$city->id}}" @selected(auth('customer')->user()->city_id==$city->id)>{{$city->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="customSelect customTomSelect">
                                                    @if(auth('customer')->user()->city_id)
                                                        <select class="tomSelect">
                                                            @foreach(auth('customer')->user()->city->districts as $district)
                                                                <option value="{{$district->id}}" @selected(auth('customer')->user()->district_id==$district->id)>{{$district->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <select name="district_id" class="tomSelect-select" id="district_select">
                                                            <option value="">İlçe Seçiniz</option>
                                                        </select>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input
                                                    type="email"
                                                    class="form-control"
                                                    id="floatingInput"
                                                    placeholder="E-Posta"
                                                    name="email"
                                                    value="{{auth()->user()->email}}"
                                                />
                                                <label for="floatingInput">E-Posta</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" style="border:0px" class="btn-pink btn-rounded">Güncelle</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </article>

@endsection
@section('scripts')
    <script>
        $('#city_select').on('change', function (){
            $('#district_select').empty();
            let city_id=$(this).val();
            $.ajax({
                url: '{{route('customer.getDistrict')}}',
                type: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'city_id': city_id
                },
                dataType:'json',
                success:function (data){
                    $.each(data, function (index, value){
                        $('#district_select').append('<option value="'+value.id + '">'+ value.name+'</option>');
                    });
                }
            });
        });
    </script>
    <script src="/front/assets/js/cutomer-menu.js"></script>

@endsection
