<?php

namespace App\Http\Requests\address;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id'=>'nullable|integer|exists:users,id',
            'province_id'=>'nullable|integer|exists:provinces,id',
            'city_id'=>'nullable|integer|exists:cities,id',
            'postal_code'=>'nullable|string',
            'address'=>'nullable|string',
            'unit'=>'nullable|string',
            'recipient_first_name'=>'nullable|string',
            'recipient_last_name'=>'nullable|string',
            'mobile'=>'nullable|string|ir_mobile',
            'national_code'=>'nullable|string|ir_mobile',
            'status'=>'nullable|numeric|in:0,1'
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
