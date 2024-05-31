<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    public function galleries()
    {
        return $this->hasMany(InterviewGallery::class, 'interview_id', 'id');
    }

    public function sliders()
    {
        return $this->hasMany(InterviewSlider::class, 'interview_id', 'id');
    }
}
