<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentController;
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
    Route::post('/clock/get', [AppointmentController::class, 'getClock']);
});
