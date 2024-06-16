<?php

namespace App\Http\Resources\Business;

use App\Http\Resources\City\CityListResource;
use App\Http\Resources\City\DistrictListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BusinessListResource extends JsonResource
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
            'email' => $this->email,
            'city' => CityListResource::make($this->cities),
            'district' => DistrictListResource::make($this->districts),
            'logo' => image($this->logo),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'wallpaper' => image($this->gallery()->first()->way ?? "default/business.png"),
            'commentCount' => $this->comments->count(),
            'point' => $this->points(),
            'address' => $this->addresss,
            'is_favorite' => $this->checkFavorite(auth('api')->id()),
            'min_price' => $this->services->min('price'),
            'approve_type' => $this->approve_type == 0 ? "Otomatik Onay" : "Hızlı Onay"
        ];
    }
}
