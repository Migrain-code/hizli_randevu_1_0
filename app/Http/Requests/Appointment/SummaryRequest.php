<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SummaryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'appointment_time' => "required",
            'personels' => "required",
            'room_id' => "nullable",
        ];
    }

    public function attributes()
    {
        return [
            'appointment_time' => "Randevu Tarihi Seçimi",
            'personels' => "Personel Seçimi",
            'room_id' => "Oda seçimi",
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
