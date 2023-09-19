<?php

namespace App\Http\Requests\aboutAttachment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAboutAttachmentRequest extends FormRequest
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
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'user_id'=>'required|integer|exists:users,id',
            'province_id'=>'required|integer|exists:provinces,id',
            'city_id'=>'required|integer|exists:cities,id',
            'postal_code'=>'required|string',
            'address'=>'required|string',
            'unit'=>'required|string',
            'recipient_first_name'=>'string',
            'recipient_last_name'=>'string',
            'mobile'=>'string|ir_mobile',
            'status'=>'required|numeric|in:0,1'


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
