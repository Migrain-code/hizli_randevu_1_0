<?php

namespace App\Http\Controllers\Api\NotificationPermission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\NotificationPermission\UpdatePermissionRequest;
use App\Http\Resources\Notification\NotificationPermissionResource;
use App\Models\CustomerNotificationPermission;
use Illuminate\Http\Request;

/**
 * @group Bildirim İzinleri
 *
 */
class NotificationPermissionController extends Controller
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
     * Bildirim listesi
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(NotificationPermissionResource::make($this->customer->permissions));
    }

    /**
     * Bildirim İzinleri Güncelleme
     *
     *
     * Not: Size bildirim izin listesinde gönderilen sütun adlarını column değişkeni ile apiye istek atmanız yeterlidir.
     * @param CustomerNotificationPermission $notificationPermission
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CustomerNotificationPermission $notificationPermission, UpdatePermissionRequest $request)
    {
          $notificationPermission->{$request->column} = !$notificationPermission->{$request->column};
          if ($notificationPermission->save()){
              return response()->json([
                 'status' => "success",
                 'message' => "Bildirim İzinleriniz Güncellendi"
              ]);
          } else{
              return response()->json([
                  'status' => "error",
                  'message' => "Sistemsel Bir Hata Sebebi İle Bildirim İzinleriniz Güncellenemedi"
              ], 422);
          }
    }
}
