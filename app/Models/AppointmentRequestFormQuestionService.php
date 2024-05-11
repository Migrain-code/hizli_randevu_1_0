<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentRequestFormQuestionService extends Model
{
    use HasFactory;

    public function service()
    {
        return $this->hasOne(ServiceSubCategory::class, 'id', 'sub_service_id');
    }
}
