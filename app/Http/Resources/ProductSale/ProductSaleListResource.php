<?php

namespace App\Http\Resources\ProductSale;

use App\Http\Resources\Business\BusinessBasicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSaleListResource extends JsonResource
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
           'productName' => $this->product->name ?? "",
           'piece' => $this->piece,
           'price' => $this->total,
           'payment_type' => $this->paymentType(),
           'seller_date' => $this->created_at->format('d.m.Y H:i'),
           'business' => BusinessBasicResource::make($this->business)
        ];
    }
}
