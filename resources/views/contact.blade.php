@extends('layouts.master')
@section('title', 'İletişim')
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
                                    İletişim
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section id="pageContent">
            <div class="container">
                <div class="contact-page">
                    <div class="info-box">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="info-item">
                                    <h3>
                                        <span> Bizi Direkt Olarak</span> <br />
                                        Aramak İsterseniz
                                    </h3>
                                    <p><a href="#">{{setting('speed_contact_phone')}}</a></p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="info-item">
                                    <h3>
                                        <span> Adresimiz  </span> <br />
                                    </h3>
                                    <p><a href="#">{{setting('speed_contact_address')}}</a></p>

                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="info-item">
                                    <h3>
                                        <span> Bizi Ulaşın </span><br />
                                        Mail Adresimiz
                                    </h3>
                                    <p><a href="mailto:{{setting('speed_contact_email')}}">{{setting('speed_contact_email')}}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="contact-form">
                        <div class="">
                            <div class="row form">
                                <div class="col-lg-6">
                                    <div class="hero">
                                        <h2>
                                            <span> Bizimle İletişime Seç</span> <br />
                                            Aklındaki soruları yazabilirsin
                                        </h2>
                                        <p>
                                            {{setting('speed_contact_text')}}
                                        </p>
                                    </div>

                                    <form action="{{route('contact')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="field">
                                                    <input type="text" name="name" value="{{old('name')}}" placeholder="Adınız"  required/>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="field">
                                                    <input type="text" name="surname" value="{{old('surname')}}" placeholder="Soyadınız"  required/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="field">
                                                    <input type="email" name="email" value="{{old('email')}}" placeholder="Mail Adresi"  required/>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="field">
                                                    <input type="phone" class="phone" name="phone" value="{{old('phone')}}" placeholder="Cep Telefonu"  required/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="field">
                                                    <input type="text" name="subject" placeholder="Konu" value="{{old('subject')}}"  required/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="field">
                                                <textarea
                                                    name="content"
                                                    id=""
                                                    cols="30"
                                                    rows="5"
                                                    placeholder="Lütfen Buraya Yazın" required>{{old('content')}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="field">
                                                    <button type="submit">Gönder</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-lg-6">
                                    <div class="map">
                                        {!! setting('speed_address_map') !!}
                                    </div>
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
