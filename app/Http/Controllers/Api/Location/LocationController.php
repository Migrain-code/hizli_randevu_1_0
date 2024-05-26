<?php

namespace App\Http\Controllers\Api\Location;

use App\Http\Controllers\Controller;
use App\Http\Resources\City\CityListResource;
use App\Http\Resources\City\DistrictListResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group İL / İlçe
 */
class LocationController extends Controller
{
    /**
     * Şehir Listesi
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(CityListResource::collection(City::all()));
    }

    /**
     * İlçe Listesi
     *
     */

    public function show(City $city)
    {
        return response()->json([
            'featured_districts' => DistrictListResource::collection($city->districts->where('is_featured', 1)),
            'districts' => DistrictListResource::collection($city->districts),
        ]);
    }
}
