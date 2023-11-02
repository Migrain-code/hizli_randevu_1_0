<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\SearchController;
use \App\Http\Controllers\AppointmentController;
use \App\Http\Controllers\BlogController;
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

Route::get('/', [HomeController::class, 'index'])->name('main');
Route::get('/hizmet/{slug}', [SearchController::class, 'service'])->name('search.service');
Route::get('/salon/{slug}', [HomeController::class, 'businessDetail'])->name('business.detail');

Route::controller(BlogController::class)->prefix('blog')->as('blog.')->group(function (){
    Route::get('/', 'index')->name('index');
    Route::get('/detay/{slug}', 'detail')->name('detail');
});

Route::controller(AppointmentController::class)->group(function (){
    Route::get('randevu-olustur/{business}', 'step1Show')->name('step1.show');
    Route::get('randevu-olustur/adim-1/save', 'step1Store')->name('step1.store');
    Route::post('randevu-olustur', 'appointmentCreate')->name('appointment.create');
    Route::get('randevu-olusturuldu/{appointment}', 'step5Show')->name('appointment.success');
});
