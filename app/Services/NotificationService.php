<?php

namespace App\Services;
use GuzzleHttp\Client;

class NotificationService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function sendPushNotification($expoToken, $title, $body)
    {
        $response = $this->client->post(env('EXPO_PUSH_URL'), [
            'json' => [
                'to' => $expoToken,
                'title' => $title,
                'body' => $body,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
