<?php

namespace App\Http\Resources\Activity;

use App\Http\Resources\City\CityListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityListResource extends JsonResource
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
          'title' => $this->getTitle(),
          'image' => image($this->image),
          'hotelName' => $this->hotel_name,
          'dateRange' => $this->start_time->translatedFormat('d F'). " ". $this->end_time->translatedFormat('d F'),
          'clock' => $this->start_time->translatedFormat('H:i'). " - ". $this->end_time->translatedFormat('H:i'),
          'city' => CityListResource::make($this->city),
        ];
    }
}
