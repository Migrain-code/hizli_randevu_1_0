<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityBusiness;
use App\Models\Ads;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::where('status', 1)->latest()->paginate(10);
        $ads = Ads::where('type', 5)->where('status', 1)->take(2)->get();
        return view('activity.index', compact('activities', 'ads'));
    }

    public function detail($slug)
    {
        $activity = Activity::where('slug', $slug)->first();
        dd($activity->images);
        $latestActivities = Activity::latest()->take(5)->get();

        return view('activity.detail', compact('activity', 'latestActivities'));
    }

    public function personelControl(Request $request)
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
