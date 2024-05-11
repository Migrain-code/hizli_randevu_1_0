<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentRequestFormService extends Model
{
    use HasFactory;

    public function service()
    {
        return $this->hasOne(BusinessService::class, 'id', 'business_service_id');
    }

    public function questions()
    {
        return $this->hasMany(AppointmentRequestFormQuestion::class, 'appointment_request_form_service_id', 'id');
    }
}
