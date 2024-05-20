<?php

namespace App\Http\Requests\Auth\Password;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|confirmed',
            'password_confirmation' => "required"
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'Şifre',
            'password_confirmation' => 'Şifre Tekrarı',
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
