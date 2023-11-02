<?php

function storage($path): string
{
    return asset('storage/' . $path);
}
function image($path){
    return env('REMOTE_URL').'/storage/'.$path;
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
