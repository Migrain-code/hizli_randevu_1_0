<?php

namespace App\Http\Controllers\Api\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ActivityLoginRequest;
use App\Http\Resources\Activity\ActivityDetailResource;
use App\Http\Resources\Activity\ActivityListResource;
use App\Models\Activity;
use App\Models\ActivityBusiness;
use App\Models\Personel;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Etkinlikler
 */
class ActivityController extends Controller
{
    /**
     * Etkinlik listesi
     *
     * Not: todayActivity aktif ise apiye urlparametere olarak gönderilecek.. aktif değilse url paramttere hiç eklenemeyecek
     * @urlParam todayActiviy
     * @urlParam city_id
     * @urlParam activity_date
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $activities = Activity::whereStatus(0)
            ->when($request->filled('todayActiviy'), function ($q){
                $q->whereDate('start_time', Carbon::now()->toDateString());
            })
            ->when($request->filled('city_id'), function ($q) use ($request){
                $q->where('city_id', $request->city_id);
            })
            ->when($request->filled('activity_date'), function ($q) use ($request){
                $q->whereDate('start_time', Carbon::parse($request->input('activity_date'))->toDateString());
            })
            ->get();
        return response()->json(ActivityListResource::collection($activities));
    }

    /**
     * Etkinlik detayı
     * @param Activity $activity
     * @return JsonResponse
     */
    public function show(Activity $activity)
    {
        return response()->json(ActivityDetailResource::make($activity));
    }

    /**
     * Etkinliğe Katıl
     * @param ActivityLoginRequest $request
     * @return JsonResponse|void
     *
     */
    public function store(ActivityLoginRequest $request)
    {
        $personel = Personel::where('phone', clearPhone($request->phone))->first();
        if ($personel) {
            if (Hash::check($request->password, $personel->password)) {
                if ($personel->activities()->where('activity_id', $request->activity_id)->first()) {
                    return response()->json([
                        'status' => "warning",
                        'message' => "Bu etkinliğe zaten katıldınız",
                    ]);
                } else {
                    $activityPersonel = new ActivityBusiness();
                    $activityPersonel->activity_id = $request->activity_id;
                    $activityPersonel->personel_id = $personel->id;
                    $activityPersonel->status = 1;
                    if ($activityPersonel->save()) {
                        return response()->json([
                            'status' => "success",
                            'message' => "Etkinliğe Katılımınız Onaylandı. Aşağıdaki Katılımcı Listesinden Görebilirsiniz",
                        ]);
                    }
                }

            } else {
                return response()->json([
                    'status' => "danger",
                    'message' => "Kullanıcı Bilgisi Doğrulanamadı",
                ]);
            }
        } else {
            return response()->json([
                'status' => "warning",
                'message' => "Girdiğiniz telefon numarası sistemde kayıtlı değil",
            ]);
        }
    }
}
