<?php

namespace App\Http\Controllers\Api\MainPage;

use App\Http\Controllers\Controller;
use App\Http\Resources\Activity\ActivityListResource;
use App\Http\Resources\Advert\AdvertListResource;
use App\Http\Resources\Advert\ProductAdvertListResource;
use App\Http\Resources\BusinessCategory\BusinessCategoryListResource;
use App\Http\Resources\Interview\InterviewListResource;
use App\Models\Activity;
use App\Models\Ads;
use App\Models\BusinessCategory;
use App\Models\Interview;
use App\Models\ProductAds;
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
        $activities = Activity::whereStatus(1)->get();
        $productAdverts = ProductAds::where('status', 1)->get();
        $interviews = Interview::whereStatus(1)->get();
        return response()->json([
           'categories' => BusinessCategoryListResource::collection($categories),
           'adverts' => AdvertListResource::collection($adverts),
           'activities' => ActivityListResource::collection($activities),
           'productAdverts' => ProductAdvertListResource::collection($productAdverts),
           'interviews' => InterviewListResource::collection($interviews),
        ]);
    }
}
