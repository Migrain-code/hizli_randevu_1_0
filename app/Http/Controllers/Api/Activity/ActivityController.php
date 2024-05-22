<?php

namespace App\Http\Controllers\Api\Activity;

use App\Http\Controllers\Controller;
use App\Http\Resources\Activity\ActivityDetailResource;
use App\Http\Resources\Activity\ActivityListResource;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Etkinlikler
 *
 */
class ActivityController extends Controller
{
    /**
     * Etkinlik listesi
     * @return JsonResponse
     *
     */
    public function index()
    {
        $activities = Activity::whereStatus(1)->get();
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
}
