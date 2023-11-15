@extends('layouts.master')
@section('title', 'Kayıt Ol')
@section('content')
    <div class="formBox">
        <div class="formBoxContent d-md-flex align-items-center">
            <div class="formBoxSlider">
                <div class="owl-carousel  owl-theme">
                    <div class="item">
                        <div class="formBoxSliderPhoto">
                            <img src="/assets/images/formbg.png" alt="">
                        </div>
                        <div class="formBoxSliderText">
                            <strong>Hizmet ve Randevu Arama Sitesi. Hızlı Randevu</strong>
                            <span>Etiam nullam donec quis velit sit at tellus. Nunc.</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="formBoxSliderPhoto">
                            <img src="/assets/images/formbg.png" alt="">
                        </div>
                        <div class="formBoxSliderText">
                            <strong>Hizmet ve Randevu Arama Sitesi. Hızlı Randevu</strong>
                            <span>Etiam nullam donec quis velit sit at tellus. Nunc.</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="formBoxSliderPhoto">
                            <img src="/assets/images/formbg.png" alt="">
                        </div>
                        <div class="formBoxSliderText">
                            <strong>Hizmet ve Randevu Arama Sitesi. Hızlı Randevu</strong>
                            <span>Etiam nullam donec quis velit sit at tellus. Nunc.</span>
                        </div>
                    </div>
                </div>
                <a href="javascript:;" class="sliderPrev">
                    <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.85937 15.2158L0.859375 8.21582L7.85938 1.21582" stroke="white" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                </a>
                <a href="javascript:;" class="sliderNext">
                    <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.31934 15.2158L8.31934 8.21582L1.31934 1.21582" stroke="white" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                </a>
            </div>
            <form method="post" action="{{route('customer.register')}}" class="formBoxForm">
                @csrf
                <div class="mb-4 text-center formLogo">
                    <img src="/assets/images/logo-pink.svg" alt="">
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" name="name" placeholder="Cep Telefonu">
                    <label for="floatingInput">Ad Soyad</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control phone" id="floatingInput" name="phone" placeholder="Cep Telefonu">
                    <label for="floatingInput">Telefon Numarası</label>
                </div>

                <div class="mb-3">
                    <div class="customCheck">
                        <div class="customCheckInput">
                            <input type="checkbox">
                            <span></span>
                        </div>
                        <span>
                            Kampanyalardan haberdar olmak için tarafıma ticari ileti gönderilsin
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="customCheck">
                        <div class="customCheckInput">
                            <input type="checkbox">
                            <span></span>
                        </div>
                        <span>
                            Kolay Randevu <a href="javacript:;"> kullanım koşullarını</a>, <a href="javacript:;"></a>gizlilik ve KVKK politikasını</a> <a href="javacript:;"></a>ve aydınlatma metnini</a> okudum, bu kapsamda verilerimin işlenmesini onaylıyorum
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" style="border: none" class="btn-pink w-100 p-4 text-center">Kayıt Ol</button>
                </div>
                <div class="mb-0">
                    <label class="registerLabel">Üyeliğiniz Var Mı?</label>
                    <a href="{{route('customer.login')}}" class="btn-gray w-100 p-4 text-center">Giriş Yap</a>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('scripts')

@endsection
