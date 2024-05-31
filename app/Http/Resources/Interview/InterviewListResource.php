<?php

namespace App\Http\Resources\Interview;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewListResource extends JsonResource
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
          'title' => $this->title,
          'name' => $this->name,
          'image' => image($this->image),
          'viewCount' => $this->views,
          'created_at' => $this->created_at->translatedFormat('d F Y')
        ];
    }
}
