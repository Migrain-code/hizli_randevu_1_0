<?php

namespace App\Http\Resources\Business;

use App\Http\Resources\City\CityListResource;
use App\Http\Resources\City\DistrictListResource;
use App\Http\Resources\Gallery\GalleryListResource;
use App\Models\DayList;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BusinessDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'instagram' =>"https://www.instagram.com/".$this->instagram,
            'email' => $this->email,
            'city' => CityListResource::make($this->cities),
            'district' => DistrictListResource::make($this->districts),
            'logo' => image($this->logo),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'wallpaper' => image($this->gallery()->first()->way ?? "default/business.png"),
            'commentCount' => $this->comments->count(),
            'point' => $this->points(),
            'address' => $this->address,
            'gender' => BusinessGenderResource::make($this->type),
            'is_favorite' => auth('api')->check() ? $this->checkFavorite(auth('api')->id()) : false,
            'services' => $this->getService(),
            'gallery' => GalleryListResource::collection($this->gallery),
            'personels' => PersonelListResource::collection($this->personel),
            'comments' => BusinessCommentListResource::collection($this->comments),
            'about' => $this->about,
            'embed' => $this->embed,
            'shareUrl' => "https://hizlirandevu.com.tr/".$this->slug,
            'workTimes' => $this->dayList(),
            'latitude' => $this->lat,
            'longitude' => $this->longitude,

        ];
    }
    public function dayList()
    {
        $dayList = DayList::all();
        $closeDays = [];
        foreach($dayList as $day){
            $closeDays[] = [
                'id' => $day->id,
                'name' => $day->name,
                'clock' => $this->start_time. " - ".$this->end_time,
                'status' => isset($this->off_day) ? $day->id != $this->off_day : true
            ];
        }
        return $closeDays;
    }
    public function getService()
    {
        $business = $this;
        $womanServicesArray = $business->services()->where('type', 1)->with('categorys')->get();
        $womanServiceCategories = $womanServicesArray->groupBy('categorys.name');
        $womanServices = $this->transformServices($womanServiceCategories);

        $manServicesArray = $business->services()->where('type', 2)->with('categorys')->get();
        $manServiceCategories = $manServicesArray->groupBy('categorys.name');
        $manServices = $this->transformServices($manServiceCategories);

        if ($business->type_id == 3) {
            return [
                'womanServices' => $womanServices,
                'manService' => $manServices
            ];
        } elseif ($business->type_id == 2) {
            return [
                'manService' => $manServices
            ];
        } else {
            return [
                'womanServices' => $womanServices,
            ];
        }

    }

    function transformServices($womanServiceCategories)
    {
        $transformedDataWoman = [];
        $transformedFeaturedServices = [];
        foreach ($womanServiceCategories as $category => $services) {
            $transformedServices = [];
            foreach ($services as $service) {
                //if ($service->personels->count() > 0) { //hizmeti veren personel sayısı birden fazla ise listede göster
                $transformedServices[] = [
                    'id' => $service->id,
                    'name' => $service->subCategory->getName(),
                    'price' => $service->price_type_id == 0 ? $service->price : $service->price . " - " . $service->max_price,
                    'is_featured' => $service->is_featured == 1,
                ];
                if ($service->is_featured == 1){
                    $transformedFeaturedServices[] = [
                        'id' => $service->id,
                        'name' => $service->subCategory->getName(),
                        'price' => $service->price_type_id == 0 ? $service->price : $service->price . " - " . $service->max_price,
                    ];
                }

            }
            $transformedDataWoman[] = [
                'id' => $services->first()->category,
                'name' => $category,
                'services' => $transformedServices,
            ];
        }
        return [
            'services' => $transformedDataWoman,
            'featured' => [
                [
                    'id' => 0,
                    'name' => "Sık Kullanılan",
                    'services' => $transformedFeaturedServices
                ]
            ],

        ];
    }
}
