<?php

namespace App\Http\Requests\Customer\NotificationPermission;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'column' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'column' => 'Bildirim adı',
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
