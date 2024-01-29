<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'business_id' => 'required',
            'services' => 'required',
            'personels' => 'required',
            'appointment_time' => 'required',
            'appointment_date' => 'required',
            'phone' => 'required',
            'name' => 'required',
        ];
    }
}
