<?php

namespace App\Http\Requests\Customer\Setting;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => 'required',
            //'email' => 'required',
            'gender' => 'required',
            'birthday'=> 'nullable|date',
            'city_id' => 'nullable',
            'district_id' => 'nullable'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Müşteri Adı',
            'phone' => 'Telefon Numarası',
            //'email' => 'E-posta',
            'gender' => 'Cinsiyet',
            'birthday'=> 'Doğum Tarihi',
            'city_id' => 'Şehir',
            'district_id' => 'İlçe'
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
