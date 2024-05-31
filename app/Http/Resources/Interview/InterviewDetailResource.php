<?php

namespace App\Http\Resources\Interview;

use App\Http\Resources\Gallery\GalleryListResource;
use App\Models\InterviewGallery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewDetailResource extends JsonResource
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
            'description' => $this->description,
            'video' => $this->vide_url,
            'created_at' => $this->created_at->translatedFormat('d F Y'),
            'gallery' => InterviewGalleryResource::collection($this->galleries),
            'slider' => InterviewGalleryResource::collection($this->sliders),

        ];
    }
}
