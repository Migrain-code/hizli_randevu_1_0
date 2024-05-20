<?php

namespace App\Http\Controllers\Api\Campaing;

use App\Http\Controllers\Controller;
use App\Http\Resources\Campaign\CampaignDetailResource;
use App\Http\Resources\Campaign\CampaignListResource;
use App\Models\Campaign;
use Illuminate\Http\Request;

/**
 * @group Kampanyalarım
 */
class CamapignController extends Controller
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
     * Kampanyalar Listesi
     * @return void
     */
    public function index()
    {
        $campaigns = $this->customer->campaigns;
        return response()->json(CampaignListResource::collection($campaigns));
    }

    /**
     * Kampanya Detayı
     * @return void
     */

    public function show(Campaign $campaign)
    {
        return response()->json(CampaignDetailResource::make($campaign));
    }
}
