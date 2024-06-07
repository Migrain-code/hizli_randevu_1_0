<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\City\CityListResource;
use App\Http\Resources\City\DistrictListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CustomerCommentResource extends JsonResource
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
            'name' => cryptName($this->name),
            'image' => image($this->image),
        ];
    }
}
