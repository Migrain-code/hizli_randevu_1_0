<?php

use App\Models\SmsConfirmation;
use App\Services\Sms;

function storage($path): string
{
    return asset('storage/' . $path);
}
function createLink($lat, $long)
{
    return "https://www.google.com/maps?q={$lat},{$long}";
}

function image($path){
    return env('IMAGE_URL').$path;
}
function setting($key){
    return config('settings.'.$key);
}
function cryptName($fullName) {
    $parts = explode(' ', $fullName);
    if (count($parts) < 2) {
        // If the name does not contain a space (i.e., only one word), return it as is
        return $fullName;
    }

    $firstName = $parts[0];
    $lastName = $parts[count($parts) - 1];

    $anonymizedLastName = $lastName[0] . str_repeat('*', strlen($lastName) - 1);

    return $firstName . ' ' . $anonymizedLastName;
}

function formatPhone($phone)
{
    return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $phone);
}
function main($key){
    return config('main_pages.'.$key);
}
function formatPrice($price)
{
    return number_format($price, 2) . ' ₺';
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
    $smsConfirmation->action = "CUSTOMER-VERIFY";
    $smsConfirmation->phone = $phone;
    $smsConfirmation->code = $generateCode;
    $smsConfirmation->expire_at = now()->addMinute(3);
    $smsConfirmation->save();

    Sms::send($phone,setting('speed_message_title'). " Sistemine giriş için, telefon numarası doğrulama kodunuz ". $generateCode);

    return $phone;
}
