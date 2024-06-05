<?php

namespace App\Http\Resources\Business;

use App\Http\Resources\City\CityListResource;
use App\Http\Resources\City\DistrictListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BusinessBasicResource extends JsonResource
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
            'logo' => image($this->logo),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'commentCount' => $this->comments->count(),
            'point' => $this->points(),
        ];
    }
}
