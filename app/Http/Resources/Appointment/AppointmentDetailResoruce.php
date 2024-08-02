<?php

namespace App\Http\Resources\Appointment;

use App\Http\Resources\Business\BusinessBasicResource;
use App\Http\Resources\Business\BusinessListResource;
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
        $totalPrice = $this->totalServiceAndProduct();
        $collectedTotal = $this->calculateCollectedTotal();
        $campaignDiscount = $this->discount;
        if (is_numeric($totalPrice)){
            $campaignDiscount = formatPrice(($totalPrice * $campaignDiscount) / 100);
            $totalPrice = formatPrice($this->totalServiceAndProduct());

        }
        if (is_numeric($collectedTotal)){
            $collectedTotal = formatPrice($collectedTotal);
        }
        return [
            'id' => $this->id,
            'business' => BusinessBasicResource::make($this->business),
            'name' => $this->customer->name,
            'date' => $this->start_time->format('d.m.Y H:i'),
            'status' => $this->status("text"),
            'statusCode' => $this->status,
            'comment_status' => $this->comment_status,
            'note' => $this->note,
            'isCampaign' => isset($this->campaign_id),
            'campaignDiscount' => $campaignDiscount,
            'cashPoint' =>  $this->point,
            'total' =>  $totalPrice, // toplam
            'collectedTotal' => $collectedTotal, // kalan
            'services' => AppointmentServiceResource::collection($this->services),
        ];
    }
}
