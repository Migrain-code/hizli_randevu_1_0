<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CheckClockRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'appointment_time' => "required",
            'personels' => "required",
        ];
    }

    public function attributes()
    {
        return [
            'appointment_time' => "Randevu Tarihi Seçimi",
            'personels' => "Personel seçimi",
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
