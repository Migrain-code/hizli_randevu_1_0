<?php

namespace App\Http\Resources\PackageSale;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageSaleListResource extends JsonResource
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
           'businessName' => $this->business->name,
           'sellerDate' => $this->seller_date->format('d.m.Y H:i'),
           'serviceName' => $this->service?->subCategory?->getName(),
           'personelName' => $this->personel->name,
           'packageType' => $this->packageType("name"),
           'amount' => $this->amount,
           'remainingAmount' => $this->amount - $this->usages->sum('amount'),
           'total' => $this->total. "₺",
           'payedTotal' => $this->payments->sum('price'),
           'remainingTotal' =>  $this->total - $this->payments->sum('price')
        ];
    }
}
