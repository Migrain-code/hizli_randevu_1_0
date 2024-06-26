<?php

namespace App\Http\Resources\Business;

use App\Http\Resources\Business\BusinessListResource;
use App\Http\Resources\Customer\CustomerCommentResource;
use App\Http\Resources\Customer\CustomerInfoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessCommentListResource extends JsonResource
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
           'content' => $this->content,
           'point' => $this->point,
           'created_at' => $this->created_at->format('d.m.Y H:i:s'),
           'customer' => CustomerCommentResource::make($this->customer),
        ];
    }
}
