<?php

namespace App\Services;
use Exception;
class WpSms
{
    protected $apiUrl = "https://my.wpileti.com/api/send-message";
    protected $apiKey = "f1051db822908a2936060a8ff2ef53ac44356b86";

    public function sendMessage($receiver, $message)
    {
        $body = [
            "api_key" => $this->apiKey,
            "receiver" => $receiver,
            "data" => ["message" => $message]
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => [
                "Accept: */*",
                "Content-Type: application/json",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #: " . $err);
        }

        return $response;
    }
}