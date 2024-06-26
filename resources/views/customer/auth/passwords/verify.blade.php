@extends('layouts.master')
@section('title', 'Şifremi Unuttum Doğrulama Yapın')
@section('content')
    <div class="formBox">
        <div class="formBoxContent d-flex align-items-center w-auto forgotPass">
            <form method="post" action="{{route('customer.forgotPasswordVerify')}}" class="formBoxForm w-auto">
                @csrf
                <div class="aut-content" style="text-align: center;margin-bottom: 26px;">
                    <h2 style="font-size: 24px;font-family: 'Euclid Circular A';">Telefon Numarası Doğrulama</h2>
                </div>
                <label class="registerLabel">Gönderdiğimiz doğrulama kodunu giriniz</label>
                <div class="form-floating mb-3">
                    <input
                        type="text"
                        class="form-control"
                        id="floatingInput"
                        name="code"
                        placeholder="Doğrulama Kodu"
                    />
                    <label for="floatingInput">Doğrulama Kodu</label>
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
