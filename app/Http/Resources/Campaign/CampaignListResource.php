<?php

namespace App\Http\Resources\Campaign;

use App\Http\Resources\Business\BusinessListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignListResource extends JsonResource
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
            'id' => $this->campaign_id,
            'title' => $this->campaign->getTitle(),
            'code' => $this->campaign->code,
            'start_time' => $this->campaign->start_time->format('d.m.Y H:i'),
            'end_time' => $this->campaign->end_date->format('d.m.Y H:i'),
            'status' => $this->campaign->end_date > now(),
            'business' => BusinessListResource::make($this->campaign->business),
        ];
    }

}
