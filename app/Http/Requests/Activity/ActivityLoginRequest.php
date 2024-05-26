<?php

namespace App\Http\Requests\Activity;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActivityLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|numeric',
            'password' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'phone' => 'Telefon',
            'password' => 'Şifre',
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
