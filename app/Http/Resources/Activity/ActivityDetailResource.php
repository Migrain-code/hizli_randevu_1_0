<?php

namespace App\Http\Resources\Activity;

use \App\Http\Resources\Activity\ActivityPersonelsResource;
use App\Http\Resources\Activity\ActivitySliderResource;
use App\Http\Resources\City\CityListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityDetailResource extends JsonResource
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
          'phone' => $this->phone,
          'personelCount' => $this->personels->count(),
          'sponsorCount' => $this->sponsors->count(),
          'description' => $this->getDescription(),
          'image' => image($this->image),
          'hotelName' => $this->hotel_name,
          'price' => $this->price,
          'dateRange' => $this->start_time->translatedFormat('d F'). " ". $this->end_time->translatedFormat('d F'),
          'clock' => $this->start_time->translatedFormat('H:i'). " - ". $this->end_time->translatedFormat('H:i'),
          'city' => CityListResource::make($this->city),
          'sponsors' => ActivitySponsorResource::collection($this->sponsors),
          'personels' => ActivityPersonelsResource::collection($this->personels),
          'photos' => ActivitySliderResource::collection($this->images),
          'embed_url' => $this->embed,
        ];
    }
}
