<?php

namespace App\Http\Requests\Customer\Favorite;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddFavoriteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'business_id' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'business_id' => 'İşletme Bilgisi',
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
