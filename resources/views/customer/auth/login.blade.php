@extends('layouts.master')
@section('title', 'Giriş Yap')
@section('content')
    <div class="formBox">
        <div class="formBoxContent d-md-flex align-items-center">
            @include('customer.auth.components.slider')
            <form class="formBoxForm" method="post" action="{{route('customer.login')}}">
                @csrf
                <div class="mb-0 mt-2">
                    <label class="registerLabel">
                        <h3>Müşteri Girişi</h3>
                    </label>
                    <label class="registerLabel">Randevularınızı Akıllıca Planlayın, İşinizi Büyütün.</label>
                </div>
                <div class="form-floating mb-3">
                    <input
                        type="text"
                        name="phone"
                        class="form-control phone"
                        id="floatingInput"
                        placeholder="Cep Telefonu"
                        value=""
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
                        value=""
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
                                    <input type="checkbox" name="remember"/>
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
