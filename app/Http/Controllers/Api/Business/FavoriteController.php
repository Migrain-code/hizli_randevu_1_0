<?php

namespace App\Http\Controllers\Api\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Favorite\AddFavoriteRequest;
use App\Http\Resources\Business\BusinessListResource;
use App\Models\Business;
use App\Models\CustomerFavorite;
use Cassandra\Custom;
use Illuminate\Http\Request;

/**
 * Favori İşletmeler
 *
 */
class FavoriteController extends Controller
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
     * Favoriler Listesi
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $businessIds = $this->customer->favorites()->has('business')->pluck('business_id');
        $businesses = Business::whereIn('id', $businessIds)->get();
        return response()->json(BusinessListResource::collection($businesses));
    }

    /**
     * Favori Ekleme / Çıkarma
     * Not: Burada yapılan koşullandırma şu şekilde:
     *  <ul>
     *      <li>Eğer işletme kullanıcının favori listesindeyse çıkarılır</li>
     *      <li>Eğer işletme kullanıcının favori listesinde değilse eklenir</li>
     *  </ul>
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddFavoriteRequest $request)
    {
        $existFavorite = $this->customer->favorites()->where('business_id', $request->business_id)->first();
        if ($existFavorite){
            $existFavorite->delete();
            return response()->json([
                'status' => "success",
                'message' => "İşletme Favorilerinizden Kaldırıldı"
            ]);
        }
        $favorite = new CustomerFavorite();
        $favorite->business_id = $request->business_id;
        $favorite->customer_id = $this->customer->id;
        if ($favorite->save()){
            return response()->json([
               'status' => "success",
               'message' => "İşletme Favorilerinize Eklendi"
            ]);
        }
    }
}
