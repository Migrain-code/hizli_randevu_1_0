<?php

namespace App\Http\Resources\Advert;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAdvertListResource extends JsonResource
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
          'title' => $this->getName(),
          'price' => $this->getPrice(),
          'link' => $this->link,
          'image' => image($this->image)
        ];
    }
}
