<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\VerifyController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Business\FavoriteController;
use \App\Http\Controllers\Api\ProductSale\ProductSaleController;
use App\Http\Controllers\Api\PackageSale\PackageSaleController;
use \App\Http\Controllers\Api\Appointment\CustomerAppointmentController;
use App\Http\Controllers\Api\Comment\CommentController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\NotificationPermission\NotificationPermissionController;
use App\Http\Controllers\Api\Campaing\CamapignController;
use App\Http\Controllers\Api\MainPage\MainPageController;
use App\Http\Controllers\Api\Location\LocationController;
use App\Http\Controllers\Api\Activity\ActivityController;
use \App\Http\Controllers\Api\Business\BusinessController;
use App\Http\Controllers\Api\Interview\InterviewController;
use App\Http\Controllers\Api\Appointment\AppointmentCreateController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/salon-ara', [\App\Http\Controllers\SearchController::class, 'salonName']);

Route::prefix('appointment')->group(function (){
    Route::post('/clock/get-2', [AppointmentController::class, 'getClock']);
});
//Anasayfa
Route::get('main-page', [MainPageController::class, 'index']);
// Şehir ve ilçe
Route::apiResource('city', LocationController::class)->only([
    'index', 'show'
]);
// Etkinlikler
Route::apiResource('activity', ActivityController::class)->only([
    'index', 'show', 'store'
]);
// Röportajlar
Route::apiResource('interview', InterviewController::class)->only([
    'index', 'show'
]);
// İşletmeler
Route::apiResource('business', BusinessController::class)->only([
    'index', 'show'
]);;
// İşletme Detayları
Route::prefix('business/{business}/')->group(function (){
   Route::get('gallery', [BusinessController::class, 'gallery']);
   Route::get('about', [BusinessController::class, 'about']);
   Route::get('personels', [BusinessController::class, 'personels']);
   Route::get('comments', [BusinessController::class, 'comments']);
});
Route::prefix('customer')->group(function (){
    Route::prefix('auth')->group(function (){
        Route::post('login', [AuthController::class, 'login']); // Giriş Yap
        Route::post('register', [AuthController::class, 'register']); // Kayıt Ol
        Route::post('verify', [VerifyController::class, 'verify']); // Kayıttaki Doğrulama

        Route::post('forgot-password', [ResetPasswordController::class, 'forgotPassword']);// Şifremi unuttum
        Route::post('forgot-password/verify', [ResetPasswordController::class, 'verifyResetPassword']); //  Şifremi Unuttum Doğrulama
    });
    Route::middleware('auth:api')->group(function () {
        // kullanıcı bilgisi
        Route::get('user', [UserController::class, 'index']);
        //Şifre Değiştir
        Route::post('change-password', [UserController::class, 'changePassword']);
        // Bilgileri Güncelle
        Route::post('update-info', [UserController::class, 'updateInfo']);
        // Profil Foto Güncelle
        Route::post('update-profile-photo', [UserController::class, 'updateProfilePhoto']);

        // Favori İşletmeler
        Route::apiResource('favorite', FavoriteController::class)->only([
            'index', 'store'
        ]);
        // Ürün Satışları
        Route::get('product-sale', [ProductSaleController::class, 'index']);

        // Paket Satışları
        Route::apiResource('package-sale', PackageSaleController::class)->only([
            'index', 'show'
        ]);

        //Randevular
        Route::apiResource('appointment', CustomerAppointmentController::class)->only([
            'index', 'update','show', 'destroy'
        ]);

        //Yorumlar
        Route::apiResource('comment', CommentController::class)->only([
            'index',
        ]);

        //Bildirimler
        Route::apiResource('notification', NotificationController::class)->only([
            'index','show'
        ]);

        //Kampanyalar
        Route::apiResource('campaign', CamapignController::class)->only([
            'index','show'
        ]);

        //Bildirim İzinleri
        Route::apiResource('notification-permission', NotificationPermissionController::class)->only([
            'index','update'
        ]);

        //Randevu oluşturma
        Route::prefix('appointment-create/{business}/')->group(function (){
            Route::get('personel', [AppointmentCreateController::class, 'getPersonel']);
            Route::get('date', [AppointmentCreateController::class, 'getDate']);
            Route::get('clock', [AppointmentCreateController::class, 'getClock']);
            Route::get('check-clock', [AppointmentCreateController::class, 'checkClock']);
            Route::post('use/coupon', [AppointmentCreateController::class, 'useCoupon']);
            Route::post('delete/coupon', [AppointmentCreateController::class, 'deleteCoupon']);
            Route::get('summary', [AppointmentCreateController::class, 'summary']);
            Route::post('create', [AppointmentCreateController::class, 'appointmentCreate']);
        });

    });

});
