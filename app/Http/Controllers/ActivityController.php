<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityBusiness;
use App\Models\Ads;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->filled('selectedDate')){
            $searchDate = Carbon::parse($request->selectedDate)->toDateString();
            $activities = Activity::where('status', 1)->whereDate('start_time',$searchDate)->latest()->paginate(10);
        } else{
            $activities = Activity::where('status', 1)->latest()->paginate(10);
        }

        $ads = Ads::where('type', 5)->where('status', 1)->take(2)->get();
        $topImages = Ads::where('type', 9)->get();
        return view('activity.index', compact('activities', 'ads', 'topImages'));
    }

    public function detail($slug)
    {
        $activity = Activity::where('slug', $slug)->first();

        $latestActivities = Activity::latest()->take(5)->get();
        $gallery = $activity->images;
        $personels = $activity->personels;
        return view('activity.detail', compact('activity', 'latestActivities', 'gallery', 'personels'));
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
