<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetPersonelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'services' => "required",
            'room_id' => "nullable",
        ];
    }

    public function attributes()
    {
        return [
            'services' => "Hizmet seçimi",
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
