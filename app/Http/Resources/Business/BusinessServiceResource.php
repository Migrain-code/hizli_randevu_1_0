<?php

namespace App\Http\Resources\Business;

use App\Http\Resources\City\CityListResource;
use App\Http\Resources\City\DistrictListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BusinessServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "type"=> $this->gender->name,
            "type_id"=> $this->gender->id,
            "category"=> $this->categorys->getName(),
            "category_id" => $this->categorys->id,
            "sub_category"=> $this->subCategory->getName(),
            "sub_category_id"=> $this->subCategory->id,
            "price"=> $this->price,
            "time" => $this->time,
            "is_featured" => $this->is_featured == 1,
        ];
    }
}
