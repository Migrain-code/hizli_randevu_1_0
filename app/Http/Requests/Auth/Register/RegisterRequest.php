<?php

namespace App\Http\Requests\Auth\Register;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|numeric',
            'name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'phone' => 'Telefon',
            'name' => 'Ad Soyad',
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
