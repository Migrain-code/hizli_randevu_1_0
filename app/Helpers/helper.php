<?php

use App\Models\SmsConfirmation;
use App\Services\Sms;

function storage($path): string
{
    return asset('storage/' . $path);
}
function image($path){
    return env('IMAGE_URL').$path;
}
function setting($key){
    return config('settings.'.$key);
}

function main($key){
    return config('main_pages.'.$key);
}

function clearPhone($phoneNumber){
    $newPhoneNumber = str_replace([' ', '(', ')', '-'], '', $phoneNumber);

    return $newPhoneNumber;

}
function hideName($name) {
    $firstChar = substr($name, 0, 1); // Kullanıcı adının ilk karakterini alır
    $hiddenPart = str_repeat('*', strlen($name) - 1); // İkinci karakterden sonraki tüm karakterleri yıldızla doldurur
    return $firstChar . $hiddenPart;
}

function createVerifyCode($phone)
{
    $generateCode=rand(100000, 999999);
    $smsConfirmation = new SmsConfirmation();
    $smsConfirmation->action = "CUSTOMER VERIFY";
    $smsConfirmation->phone = $phone;
    $smsConfirmation->code = $generateCode;
    $smsConfirmation->expire_at = now()->addMinute(3);
    $smsConfirmation->save();

    Sms::send($phone,config('settings.speed_site_title'). " Sistemine giriş için, telefon numarası doğrulama kodunuz ". $generateCode);

    return $phone;
}
