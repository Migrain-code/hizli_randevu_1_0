@extends('layouts.master')
@section('title', 'Yeni Kullanıcı Kaydı')
@section('content')
    <div class="formBox">
        <div class="formBoxContent d-md-flex align-items-center">
            @include('customer.auth.components.slider')
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
