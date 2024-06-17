<?php

namespace App\Http\Controllers\Api\Business;

use App\Http\Controllers\Controller;
use App\Http\Resources\Business\BusinessAboutResource;
use App\Http\Resources\Business\BusinessCommentListResource;
use App\Http\Resources\Business\BusinessDetailResource;
use App\Http\Resources\Business\BusinessListResource;
use App\Http\Resources\Business\PersonelListResource;
use App\Http\Resources\Gallery\GalleryListResource;
use App\Models\Business;
use App\Models\DayList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @group İşletmeler
 */
class BusinessController extends Controller
{
    /**
     * İşletme Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function index(Request $request)
    {
        $businesses = Business::where('status', 1)->has('personel')->has('services')
            ->when($request->filled('name'), function ($q) use ($request){
                $q->where('name', 'like', '%' . $request->input('name') . '%');
            })
            ->when($request->filled('gender'), function ($q) use ($request){
                $q->where('type_id', $request->input('gender'));
            })
            ->when($request->filled('order_type'), function ($q) use($request){
                $orderType = $request->input('order_type');
                if ($orderType == "popularity"){
                    $q->withCount('appointments')
                        ->orderBy('appointments_count', 'desc');
                } elseif ($orderType == "star_rating"){
                    $q->withAvg('comments', 'point')
                        ->orderBy('comments_avg_point', 'desc');
                } elseif ($orderType == "min_price"){
                    $q->join('services', 'services.business_id', '=', 'businesses.id')
                        ->select('businesses.*', DB::raw('MIN(services.price) as min_price'))
                        ->groupBy('businesses.id')
                        ->orderBy('min_price', 'asc');
                }elseif ($orderType == "max_price"){
                    $q->join('services', 'services.business_id', '=', 'businesses.id')
                        ->select('businesses.*', DB::raw('MAX(services.price) as max_price'))
                        ->groupBy('businesses.id')
                        ->orderBy('max_price', 'asc');
                }
            })
            ->when($request->filled('lat'), function ($q) use ($request){
                $lat = $request->input('lat');
                $lng = $request->input('long');

                $distance = 20;
                $q->selectRaw("(6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance", [$lat, $lng, $lat])
                    ->havingRaw("distance < ?", [$distance]);
            })
            ->when($request->filled('category_id'), function ($q) use ($request){
                $q->where('category_id', $request->input('category_id'));
            })
            ->when($request->filled('city_id'), function ($q) use ($request){
                $q->where('city', $request->input('city_id'));
            })
            ->when($request->filled('district_id'), function ($q) use ($request){
                $q->where('district', $request->input('district_id'));
            })
            ->get();

        return response()->json(BusinessListResource::collection($businesses));
    }

    /**
     * İşletme Detay
     *
     * @param Business $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Business $business)
    {
        return response()->json(BusinessDetailResource::make($business));
    }

    /**
     * İşletme Galerisi
     *
     * @param Business $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function gallery(Business $business)
    {
        return response()->json(GalleryListResource::collection($business->gallery));
    }

    /**
     * İşletme Hakkımızda
     *
     * @param Business $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function about(Business $business)
    {
        return response()->json(BusinessAboutResource::make($business));
    }

    /**
     * İşletme Personel Listesi
     *
     * @param Business $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function personels(Business $business)
    {
        return response()->json(PersonelListResource::collection($business->personel));
    }

    /**
     * İşletme Yorum Listesi
     *
     * @param Business $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function comments(Business $business)
    {
        return response()->json(BusinessCommentListResource::collection($business->comments));
    }
}
