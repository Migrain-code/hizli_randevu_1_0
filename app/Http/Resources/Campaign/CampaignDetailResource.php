<?php

namespace App\Http\Resources\Campaign;

use App\Http\Resources\Business\BusinessListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->getTitle(),
            'code' => $this->code,
            'start_time' => $this->start_time->format('d.m.Y'),
            'end_time' => $this->end_date->format('d.m.Y'),
            'image' => image($this->image),
            'discount' => "%".$this->discount,
            'description' => $this->getDescription(),
            'business' => BusinessListResource::make($this->business),
        ];
    }

}
