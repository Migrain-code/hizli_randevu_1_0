@extends('layouts.master')
@section('title', 'Bildirim izinleri')
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
                                    Bildirim İzinleri
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
                                <div id="profileContentBox">
                                    <div class="profileTitle">Bildirim İzinleri</div>
                                    <div class="notificationSettings">
                                        <div class="notificationSettingsItem">
                                            <div class="row">
                                                <div class="col-8 col-lg-10">
                                                    <strong>Anlık Bildirimler</strong>
                                                    <p>Uygulama üzerinden önemli bildirimleri alın</p>
                                                </div>
                                                <div
                                                    class="col-4 col-lg-2 d-flex align-items-center justify-content-end"
                                                >
                                                    <div class="form-check form-switch">
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            role="switch"
                                                            id="flexSwitchCheckChecked"
                                                            name="is_notification"
                                                            @checked(auth('customer')->user()->permissions->is_notification == 1)
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="notificationSettingsItem">
                                            <div class="row">
                                                <div class="col-8 col-lg-10">
                                                    <strong>Kampanya İzinleri</strong>
                                                    <p>Kampanya Bildirimleri Göndermemize izin verin</p>
                                                </div>
                                                <div
                                                    class="col-4 col-lg-2 d-flex align-items-center justify-content-end"
                                                >
                                                    <div class="form-check form-switch">
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            role="switch"
                                                            id="flexSwitchCheckChecked"
                                                            name="is_email"
                                                            @checked(auth('customer')->user()->permissions->is_email == 1)
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--
                                            <div class="notificationSettingsItem">
                                            <div class="row">
                                                <div class="col-8 col-lg-10">
                                                    <strong>Sms</strong>
                                                    <p>Size sms göndermemize izin verin</p>
                                                </div>
                                                <div
                                                    class="col-4 col-lg-2 d-flex align-items-center justify-content-end"
                                                >
                                                    <div class="form-check form-switch">
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            role="switch"
                                                            id="flexSwitchCheckChecked"
                                                            name="is_sms"
                                                            @checked(auth('customer')->user()->permissions->is_sms == 1)
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="notificationSettingsItem">
                                            <div class="row">
                                                <div class="col-8 col-lg-10">
                                                    <strong>Telefon Görüşmeleri</strong>
                                                    <p>Telefon ile aranmaya izin</p>
                                                </div>
                                                <div
                                                    class="col-4 col-lg-2 d-flex align-items-center justify-content-end"
                                                >
                                                    <div class="form-check form-switch">
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            role="switch"
                                                            id="flexSwitchCheckChecked"
                                                            name="is_phone"
                                                            @checked(auth('customer')->user()->permissions->is_phone == 1)
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        --}}
                                    </div>

                                </div>
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
        // Tüm form elementlerini seçin
        var formElements = document.querySelectorAll('.notificationSettingsItem input');

        // Her bir inputun değişiklik olayını dinleyin
        formElements.forEach(function(input) {
            input.addEventListener('change', function() {
                // İlgili verileri hazırlayın (örneğin: name ve checked durumu)
                var name = input.getAttribute('name');
                var checked = input.checked;

                // AJAX post isteği gönderin
                fetch('/customer/update/permission', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{csrf_token()}}' // Laravel CSRF token'ını burada eklemelisiniz
                    },
                    body: JSON.stringify({
                        name: name,
                        checked: checked
                    })
                })
                    .then(function(response) {
                        if (response.status === 200) {
                            Swal.fire({
                                title: 'Bildirim Ayarlarınız Güncellendi',
                                icon:'success',
                                confirmButtonText: "Tamam"
                            });
                        } else {
                            console.error('İstek sırasında hata oluştu.');
                        }
                    });
            });
        });

    </script>
@endsection
