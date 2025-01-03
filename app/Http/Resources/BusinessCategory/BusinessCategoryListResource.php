<?php

namespace App\Http\Resources\BusinessCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessCategoryListResource extends JsonResource
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
          'name' => $this->getName(),
          'icon' => image($this->icon),
          'image' => image($this->mobile_image),
          'description' => $this->getDescription(),
          'color' => $this->color,
        ];
    }
}
