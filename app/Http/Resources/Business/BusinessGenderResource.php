<?php

namespace App\Http\Resources\Business;

use App\Http\Resources\City\CityListResource;
use App\Http\Resources\City\DistrictListResource;
use App\Models\DayList;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BusinessGenderResource extends JsonResource
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
        ];
    }
}
