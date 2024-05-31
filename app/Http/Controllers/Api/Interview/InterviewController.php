<?php

namespace App\Http\Controllers\Api\Interview;

use App\Http\Controllers\Controller;
use App\Http\Resources\Interview\InterviewDetailResource;
use App\Http\Resources\Interview\InterviewListResource;
use App\Models\Interview;
use Illuminate\Http\Request;

/**
 * @group Röportajlar
 *
 */
class InterviewController extends Controller
{
    /**
     * Röportaj Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $interviews = Interview::whereStatus(1)->get();
        return response()->json(InterviewListResource::collection($interviews));
    }

    /**
     * Röportaj Detay
     *
     * @param Interview $interview
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Interview $interview)
    {
        $interview->views += 1;
        $interview->save();
        return response()->json(InterviewDetailResource::make($interview));
    }
}
