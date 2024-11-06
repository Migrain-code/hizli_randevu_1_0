<?php

namespace App\Services;

use App\Models\SendedSms;
use Exception;

class Sms
{
    private static string $apiUrl = "https://api.netgsm.com.tr/bulkhttppost.asp";
    const USERNAME = '4646060976';
    const PASSWORD = 'V3.7CHR5';
    const TITLE = 'Hizlirandvu';

    private static function formatNumber($number)
    {
        // Eğer numara "0" ile başlıyorsa "9" ekleyerek "90..." formatına dönüştür
        if (strpos($number, '0') === 0) {
            return '9' . $number;
        }
        // Aksi takdirde "90" ekle
        return '90' . $number;
    }

    public static function send($number, $message)
    {
        // Öncelikle WpIleti üzerinden gönderim yapmayı deneyelim
        try {
            $number = self::formatNumber($number);
            $wpIletiService = new WpSms();
            $wpIletiResponse = $wpIletiService->sendMessage($number, $message);

            // WpIleti'den başarılı yanıt geldiyse veritabanına kaydedelim ve işleme son verelim
            if ($wpIletiResponse) {
                $sms = new SendedSms();
                $sms->phone = $number;
                $sms->message = $message;
                $sms->save();

                return $wpIletiResponse;
            }
        } catch (Exception $e) {
            // Hata durumunda NetGSM ile gönderim yapmayı deneyelim
            $curl = curl_init();

            $sms = new SendedSms();
            $sms->phone = $number;
            $sms->message = $message;
            $sms->save();

            curl_setopt_array($curl, [
                CURLOPT_URL => self::$apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'usercode' => self::USERNAME,
                    'password' => self::PASSWORD,
                    'gsmno' => $number,
                    'message' => $message,
                    'msgheader' => self::TITLE,
                    'filter' => '0',
                    'startdate' => '',
                    'stopdate' => '',
                ],
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        }
    }
}
