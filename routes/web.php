<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\SearchController;
use \App\Http\Controllers\AppointmentController;
use \App\Http\Controllers\BlogController;
use \App\Http\Controllers\ActivityController;
use \App\Http\Controllers\Customer\Auth\LoginController;
use \App\Http\Controllers\Customer\Auth\RegisterController;
use \App\Http\Controllers\Customer\Auth\VerifyController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\BusinessTakePriceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('main');
/*Route::domain('{business_slug}.hizlirandevu.com.tr')->group(function (){
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'businessDetail'])->name('business.detail');
});*/
Route::get('/salon/{slug}', [\App\Http\Controllers\HomeController::class, 'businessDetail'])->name('business.detail');
Route::get('/salon/{slug}/fiyat-al', [BusinessTakePriceController::class, 'businessTakePrice'])->name('business.takePrice');
Route::post('/salon/take-price/service/select', [BusinessTakePriceController::class, 'takePriceQuestion'])->name('business.takePriceQuestion');
Route::post('/salon/{slug}/take-price', [BusinessTakePriceController::class, 'takePriceQuestionForm'])->name('business.takePriceQuestionForm');

Route::get('/business/{id}', [\App\Http\Controllers\HomeController::class, 'businessId']);
Route::get('/biz-kimiz', [\App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/destek-1', [\App\Http\Controllers\HomeController::class, 'support'])->name('support');
Route::get('/iletisim', [\App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('/iletisim', [\App\Http\Controllers\HomeController::class, 'contactAdd']);
Route::get('/destek', [\App\Http\Controllers\HomeController::class, 'faq'])->name('faq');
Route::get('/page/{slug}', [\App\Http\Controllers\HomeController::class, 'page'])->name('page.detail');

Route::controller(BlogController::class)->prefix('blog')->as('blog.')->group(function (){
    Route::get('/', 'index')->name('index');
    Route::get('/detay/{slug}', 'detail')->name('detail');
    Route::get('/kategori/{slug}', 'category')->name('category');
});

Route::controller(ActivityController::class)->prefix('etkinlik')->as('activity.')->group(function (){
    Route::get('/', 'index')->name('index');
    Route::get('/detay/{slug}', 'detail')->name('detail');
    Route::post('/personel/control', 'personelControl')->name('personel.control');
});

Route::controller(AppointmentController::class)->group(function (){
    Route::get('randevu-olustur/{business}', 'step1Show')->name('step1.show');
    Route::get('randevu-olustur/adim-1/save', 'step1Store')->name('step1.store');
    Route::post('randevu-olustur', 'appointmentCreate')->name('appointment.create');
    Route::get('randevu-olusturuldu/{appointment}', 'step5Show')->name('appointment.success');
    Route::post('/clock/get', 'getClock')->name('appointment.clocks');
    Route::get('/phone/control', 'phoneControl')->name('appointment.phoneControl');
    Route::get('/phone/verify', 'phoneVerify')->name('appointment.phoneVerify');
});

Route::controller(SearchController::class)->prefix('ara')->as('search.')->group(function () {
    Route::get('/hizmet/{service}', 'service')->name('service');
    Route::get('/isletme-ara/{city}/{category}', 'cityAndCategory')->name('cityAndCategory');

    Route::post('/hizmet-ara', 'cityAndServiceCategory')->name('cityAndServiceCategory');
    Route::get('/sehire-gore-ara/{city}', 'citySearch')->name('citySearch');
    Route::get('/hizmete-gore-ara/{service}', 'serviceCategorySearch')->name('serviceCategorySearch');
    Route::get('/hizmete-ve-sehire-gore-ara/{city}/{service}', 'serviceCityAndCategorySearch')->name('serviceCityAndCategorySearch');
    Route::get('/sehire-ilce-hizmet-ara/{city}/{district}/{service}', 'serviceCityAndDistrictCategorySearch')->name('serviceCityAndDistrictCategorySearch');

    Route::post('/ture-gore-ara', 'businessCategoryAndCity')->name('businessCategoryAndCity');
    Route::get('/ture-gore-ara/{category}', 'businessCategorySearch')->name('businessCategorySearch');
    Route::get('/ture-ve-sehire-gore-ara/{city}/{service}', 'businessCategoryAndCitySearch')->name('businessCategoryAndCitySearch');
    Route::get('/sehir-ilce-kategori/{city}/{district}/{service}', 'businessCategoryAndCityAndDistrictSearch')->name('businessCategoryAndCityAndDistrictSearch');
});

Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    /*----------------------------- ilk kayıt ---------------------------------------------------*/
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    /*----------------------------- ilk kayıtta yapılan doğrulama işlemi burada yapılır /telefon-dogrulama rotalarında ---------------------------------------------------*/
    Route::get('/telefon-dogrulama', [VerifyController::class, 'phoneVerify'])->name('phone.verify');
    Route::post('/telefon-dogrulama', [VerifyController::class, 'phoneVerifyAction'])->name('phone.verify.action');

    /*----------------------------- Şifremi unuttum görünüm ve post ---------------------------------------------------*/
    Route::get('/sifremi-unuttum', [ResetPasswordController::class, 'showForgotView'])->name('showForgotView');
    Route::post('/sifremi-unuttum', [ResetPasswordController::class, 'forgotPasswordPhone'])->name('forgotPasswordPhone');

    /*----------------------------- Şifremi unuttumdan sonraki telefon doğrulama ve post ve post ---------------------------------------------------*/
    Route::get('/sifremi-unuttum/kod-dogrula', [ResetPasswordController::class, 'forgotPasswordVerifyShow'])->name('forgotPasswordVerifyShow');
    Route::post('/verify_code', [ResetPasswordController::class, 'forgotPasswordVerify'])->name('forgotPasswordVerify');

    /*----------------------------- Telefon henüz doğrulanmamışsa middlewaredan geri dönen routes ---------------------------------------------------*/
    Route::get('/hesap-dogrulama', [VerifyController::class, 'accountVerify'])->name('account.verify');
    Route::post('/hesap-dogrulama', [VerifyController::class, 'accountVerifyAction'])->name('account.verify.action');

    Route::middleware(['auth:customer', 'active', 'banned'])->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/yorumlar', [HomeController::class, 'comments'])->name('comments');
        Route::get('/favori-isletmeler', [HomeController::class, 'favorites'])->name('favorite.index');
        Route::get('/ürün-siparislerim', [HomeController::class, 'orders'])->name('order.index');
        Route::post('district/get', [HomeController::class, 'getDistrict'])->name('getDistrict');
        Route::post('/appointment/cancel', [HomeController::class, 'cancelAppointment'])->name('appointment.cancel');
        Route::post('/add/favorite', [HomeController::class, 'addFavorite'])->name('favorite.add');
        Route::post('/remove/favorite', [HomeController::class, 'removeFavorite'])->name('favorite.remove');
        Route::get('/paketlerim', [HomeController::class, 'packets'])->name('packet.index');
        Route::get('/kampanyalarim', [HomeController::class, 'campaigns'])->name('campaign.index');
        Route::get('/paket/{id}/detay', [HomeController::class, 'packetDetail'])->name('packet.detail');
        Route::get('/gecmis-randevularım', [HomeController::class, 'appointments'])->name('appointment.index');
        Route::get('/randevu/{id}/detay', [HomeController::class, 'appointmentDetail'])->name('appointment.detail');
        Route::post('/appointment/comment/store', [HomeController::class, 'addComment'])->name('appointment.comment.store');
        Route::get('/campaign/{slug}', [HomeController::class, 'campaignDetail'])->name('campaign.detail');
        Route::get('/bildirimler', [HomeController::class, 'notifications'])->name('notification');
        Route::get('/bildirim/detay/{slug}', [HomeController::class, 'notificationDetail'])->name('notification.detail');
        Route::get('/bildirim-izinleri', [HomeController::class, 'permissions'])->name('permissions');
        Route::post('/update/permission', [HomeController::class, 'updatePermission']);
        Route::controller(ProfileController::class)->prefix('profile')->as('profile.')->group(function () {
            Route::get('/hesap-ayarlari', 'edit')->name('edit');
            Route::get('/sifre-degistir', 'editPassword')->name('password.edit');
            Route::post('/update', 'update')->name('update');
            Route::post('/change-password', 'changePassword')->name('change-password');
        });
    });
});
