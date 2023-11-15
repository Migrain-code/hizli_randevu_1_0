@extends('layouts.master')
@section('title', 'Şifre Değişikliği')
@section('meta_description', 'Şifre Değişikliği')
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

                                <li class="breadcrumb-item">
                                    <a href="{{route('customer.profile.edit')}}">Ayarlar</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Şifre Değişikliği
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
                                <form method="post" action="{{route('customer.profile.change-password')}}" class="profileSettings">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="floatingInput"
                                                    placeholder="Ad"
                                                    name="password"
                                                />
                                                <label for="floatingInput">Şifre</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="floatingInput"
                                                    placeholder="Soyad"
                                                    name="password_confirmation"
                                                />
                                                <label for="floatingInput">Şifre Tekrarı</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-start">
                                            <button type="submit" style="border: 0px;" class="btn-pink btn-rounded">Güncelle</button>
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

@endsection
