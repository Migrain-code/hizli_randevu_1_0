@extends('layouts.master')
@section('title', 'Telefon Numarası Doğrulama')
@section('content')
    <div class="formBox">
        <div class="formBoxContent d-flex align-items-center w-auto forgotPass">
            <form method="post" action="{{route('customer.forgotPasswordPhone')}}" class="formBoxForm w-auto">
                @csrf
                <div class="mb-5 text-center formLogo">
                    <img src="/assets/images/logo-pink.svg" alt="" />
                </div>
                <label class="registerLabel">Şifrenizi mi Unuttunuz</label>
                <div class="form-floating mb-3">
                    <input
                        type="text"
                        class="form-control phone"
                        id="floatingInput"
                        name="phone"
                        placeholder="Cep Telefonu"
                    />
                    <label for="floatingInput">Telefon Numaranız</label>
                </div>

                <div class="back-sign-page">
                    <a href="{{route('customer.login')}}">Giriş ekranına geri dön</a>
                </div>

                <div class="mb-3">
                    <button type="submit" style="border: 0" class="btn-pink w-100 p-4 text-center">Doğrula</button>
                </div>

                <div class="mt-5">
                    <label class="registerLabel">Üyeliğiniz Yok Mu?</label>
                    <a href="{{route('customer.register')}}" class="btn-gray w-100 p-4 text-center">Ücretsiz Kayıt Ol</a>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('scripts')

@endsection
