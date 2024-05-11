<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentRequestForm extends Model
{
    use HasFactory;

    public function services()
    {
        return $this->hasMany(AppointmentRequestFormService::class, 'appointment_request_form_id', 'id');
    }

}
