<?php

namespace App\Http\Resources\Appointment;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentDetailResoruce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->customer->name,
            'date' => $this->start_time->format('d.m.Y H:i'),
            'status' => $this->status("text"),
            'statusCode' => $this->status,
            'comment_status' => $this->comment_status,
            'note' => $this->note,
            'isCampaign' => isset($this->campaign_id),
            'campaignDiscount' => number_format(($this->totalServiceAndProduct() * $this->discount) / 100, 2),
            'cashPoint' =>  $this->point,
            'total' => formatPrice($this->totalServiceAndProduct()), // toplam
            'collectedTotal' => formatPrice($this->calculateCollectedTotal()), // kalan
            'services' => AppointmentServiceResource::collection($this->services),
        ];
    }
}
