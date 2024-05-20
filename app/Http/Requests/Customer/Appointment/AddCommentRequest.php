<?php

namespace App\Http\Requests\Customer\Appointment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rating' => "required|min:1",
            'content' => "required",
            'terms' => "accepted",
        ];
    }

    public function attributes()
    {
        return [
            'rating' => "Puan",
            'content' => "Yorum Metni",
            'terms' => "Şartlar ve Koşullar"
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
