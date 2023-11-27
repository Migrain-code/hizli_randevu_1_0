@extends('layouts.master')
@section('title', 'Giriş Yap')
@section('content')
    <div class="formBox">
        <div class="formBoxContent d-md-flex align-items-center">
            <div class="formBoxSlider">
                <div class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="formBoxSliderPhoto">
                            <img src="/assets/images/formbg.png" alt="" />
                        </div>
                        <div class="formBoxSliderText">
                            <strong>Hizmet ve Randevu Arama Sitesi. Hızlı Randevu</strong>
                            <span>Etiam nullam donec quis velit sit at tellus. Nunc.</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="formBoxSliderPhoto">
                            <img src="/assets/images/formbg.png" alt="" />
                        </div>
                        <div class="formBoxSliderText">
                            <strong>Hizmet ve Randevu Arama Sitesi. Hızlı Randevu</strong>
                            <span>Etiam nullam donec quis velit sit at tellus. Nunc.</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="formBoxSliderPhoto">
                            <img src="/assets/images/formbg.png" alt="" />
                        </div>
                        <div class="formBoxSliderText">
                            <strong>Hizmet ve Randevu Arama Sitesi. Hızlı Randevu</strong>
                            <span>Etiam nullam donec quis velit sit at tellus. Nunc.</span>
                        </div>
                    </div>
                </div>
                <a href="javascript:;" class="sliderPrev">
                    <svg
                        width="9"
                        height="16"
                        viewBox="0 0 9 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M7.85937 15.2158L0.859375 8.21582L7.85938 1.21582"
                            stroke="white"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>
                <a href="javascript:;" class="sliderNext">
                    <svg
                        width="10"
                        height="16"
                        viewBox="0 0 10 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M1.31934 15.2158L8.31934 8.21582L1.31934 1.21582"
                            stroke="white"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>
            </div>
            <form class="formBoxForm" method="post" action="{{route('customer.login')}}">
                @csrf
                <div class="mb-5 text-center formLogo">
                    <img src="/assets/images/logo-pink.svg" alt="" />
                </div>
                <div class="form-floating mb-3">
                    <input
                        type="text"
                        name="phone"
                        class="form-control phone"
                        id="floatingInput"
                        placeholder="Cep Telefonu"
                        value="5537021355"
                    />
                    <label for="floatingInput">Cep Telefonu</label>
                </div>
                <div class="form-floating mb-3 passwordInput">
                    <input
                        name="password"
                        type="password"
                        class="form-control passwordEye"
                        id="floatingInputPassword"
                        placeholder="Şifre"
                        value="123456"
                    />
                    <label for="floatingInputPassword">Şifre</label>
                    <a href="javascript:;" onclick="togglePasswordVisibility()">
                        <i id="eyeIcon" class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <div class="customCheck">
                                <div class="customCheckInput">
                                    <input type="checkbox" />
                                    <span></span>
                                </div>
                                <span> Beni Hatırla </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center justify-content-end">
                        <div class="mb-3">
                            <a href="{{route('customer.showForgotView')}}" class="forgotPass">Şifremi Unuttum</a>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" style="border: 0px" class="btn-pink w-100 p-4 text-center">
                        Giriş Yap
                    </button>
                </div>
                <div class="mb-0">
                    <label class="registerLabel">Üyeliğiniz Yok Mu?</label>
                    <a href="{{route('customer.register')}}" class="btn-gray w-100 p-4 text-center">Ücretsiz Kayıt Ol</a>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('floatingInputPassword');
            var eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'fa fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'fa fa-eye';
            }
        }
    </script>
@endsection
