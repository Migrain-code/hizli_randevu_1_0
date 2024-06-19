<?php

namespace App\Http\Controllers\Api\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Appointment\AddCommentRequest;
use App\Http\Requests\Customer\Favorite\AddFavoriteRequest;
use App\Http\Resources\Appointment\AppointmentDetailResoruce;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Http\Resources\Business\BusinessListResource;
use App\Models\Appointment;
use App\Models\Business;
use App\Models\BusinessComment;
use App\Models\CustomerFavorite;
use Cassandra\Custom;
use Illuminate\Http\Request;

/**
 * @group Randevularım
 *
 */
class CustomerAppointmentController extends Controller
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
     * Randevu Listesi
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $appointments = $this->customer->appointments()->orderBy('status', 'asc')->get();
        return response()->json(AppointmentResource::collection($appointments));
    }

    /**
     * Randevuya Yorum Yap
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AddCommentRequest $request, Appointment $appointment)
    {
        if ($appointment->status == 6 or $appointment->status == 5) {
            if ($appointment->comment_status == 0) {
                $businessComment = new BusinessComment();
                $businessComment->business_id = $appointment->business_id;
                $businessComment->appointment_id = $appointment->id;
                $businessComment->customer_id = $this->customer->id;
                $businessComment->point = $request->input('rating');
                $businessComment->content = $request->input('content');
                if ($businessComment->save()) {
                    $appointment->comment_status = 1;
                    if ($appointment->save()) {
                        return response()->json([
                            'status' => "success",
                            'message' => "Yorumunuz Başarılı Bir Şekilde İletildi"
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'status' => "warning",
                    'message' => "Bu randevuya yorum gönderdiniz başka yorum gönderemezsiniz."
                ], 422);
            }
        } else {
            return response()->json([
                'status' => "warning",
                'message' => "Bu randevuya yorum yapabilmek için randevunun tamamlanmasını beklemeniz gerekmektedir."
            ], 422);
        }
    }

    /**
     * Randevu Detayı
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Appointment $appointment)
    {
        return response()->json(AppointmentDetailResoruce::make($appointment));
    }

    /**
     * Randevu İptali
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Appointment $appointment)
    {
        if ($appointment->status = 0 || $appointment->status == 1) {
            $appointment->status = 3;
            foreach ($appointment->services as $service) {
                $service->status = 3;
                $service->save();
            }
            if ($appointment->save()) {
                return response()->json([
                    'status' => "success",
                    'message' => "Randevunuz Başarılı Bir Şekilde İptal Edildi",
                ]);
            }
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Randevu artık iptal edilemez",
            ], 422);
        }
    }
}
