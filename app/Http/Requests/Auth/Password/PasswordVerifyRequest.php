<?php

namespace App\Http\Requests\Auth\Password;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PasswordVerifyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'Doğrulama Kodu',
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
