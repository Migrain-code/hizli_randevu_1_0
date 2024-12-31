<?php

namespace App\Http\Controllers\Api\MainPage;

use App\Http\Controllers\Controller;
use App\Http\Resources\Activity\ActivityListResource;
use App\Http\Resources\Advert\AdvertListResource;
use App\Http\Resources\Advert\ProductAdvertListResource;
use App\Http\Resources\Business\BusinessListResource;
use App\Http\Resources\BusinessCategory\BusinessCategoryListResource;
use App\Http\Resources\Interview\InterviewListResource;
use App\Http\Resources\Service\ServiceListResource;
use App\Models\Activity;
use App\Models\Ads;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Interview;
use App\Models\ProductAds;
use App\Models\ServiceSubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Anasayfa
 */
class MainPageController extends Controller
{
    /**
     * Anasayfa Apisi
     * @return JsonResponse
     */
    public function index()
    {
        $categories = BusinessCategory::where('is_menu', 1)->whereStatus(1)->orderBy('order_number', 'asc')->get();
        $adverts = Ads::where('type', 10)->whereStatus(1)->get();
        $businesses = Business::where('setup_status', 1)
            ->has('personel')
            ->has('services')
            ->has('appointments')
            ->withCount('appointments')
            ->having('appointments_count', '>', 10)
            ->latest()
            ->take(3)
            ->get();
        /* ******* Silinecek Veriler ********** */
        $activities = Activity::whereStatus(1)->get();
        $productAdverts = ProductAds::where('status', 1)->get();
        $interviews = Interview::whereStatus(1)->get();


        $services = ServiceSubCategory::where('is_featured', 1)/*->whereStatus(1)*/->orderBy('order_number', 'asc')->get();
        $isNotification = false;
        if (auth('api')->check()){
            $user = auth('api')->user();
            if ($user->unReadNotifations->count() > 0){
                $isNotification = true;
            }
        }
        return response()->json([
           'adverts' => AdvertListResource::collection($adverts),
           'services' => ServiceListResource::collection($services),
           'categories' => BusinessCategoryListResource::collection($categories),
           'businesses' => BusinessListResource::collection($businesses),
            'is_notification' => $isNotification,
            /* ******* Silinecek Veriler ********** */
           'activities' => ActivityListResource::collection($activities),
          'productAdverts' => ProductAdvertListResource::collection($productAdverts),
          'interviews' => InterviewListResource::collection($interviews),
        ]);
    }
}
