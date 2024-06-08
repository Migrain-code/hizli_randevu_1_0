<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'services' => "required",
            'personels' => "required",
            'appointment_time' => "required",
            'room_id' => "nullable"
        ];
    }

    public function attributes()
    {
        return [
            'services' => "Hizmetler",
            'personels' => "Personeller",
            'appointment_time' => "Randevu Tarihi ve Saati",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors()->all(),
        ], 422));
    }
}
