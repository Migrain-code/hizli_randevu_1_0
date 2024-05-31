<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationListResource;
use App\Models\CustomerNotificationMobile;

/**
 * @group Bildirimler
 *
 */
class NotificationController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->customer = auth('api')->user();
            return $next($request);
        });
    }

    /**
     * Bildirim Listesi
     *
     *  Bildirim Durumları
     *  0 => Okunmadı
     *  1 => okundu
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $notifications = $this->customer->notifications()->latest()->get();
        return response()->json(NotificationListResource::collection($notifications));
    }

    /**
     * Bildirim Detayı
     * @param CustomerNotificationMobile $notification
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function show(CustomerNotificationMobile $notification)
    {
        $notification->status = 1;
        if ($notification->save()){
            return response()->json(NotificationListResource::make($notification));
        }
    }
}
