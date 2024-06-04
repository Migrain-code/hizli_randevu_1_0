<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\City\CityListResource;
use App\Http\Resources\City\DistrictListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CustomerInfoResource extends JsonResource
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
            'city' => CityListResource::make($this->city),
            'district' => DistrictListResource::make($this->district),
            'user_gender' => $this->gender,
            'gender' => [
                1 => [
                    'id' => 1,
                    "name" => "Kadın",
                ],
                2 => [
                    'id' => 1,
                    "name" => "Erkek",
                ],
            ],
            'image' => image($this->image),
            'birthday' => Carbon::parse($this->birthday)->format('d.m.Y')
        ];
    }
}
