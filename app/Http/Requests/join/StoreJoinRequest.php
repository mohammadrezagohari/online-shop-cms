<?php

namespace App\Http\Requests\join;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreJoinRequest extends FormRequest
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
            'first_name'   => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'company_name'   => 'required|string|max:255',
            'referral_code'   => 'nullable|string|max:255',
            'mobile'   => 'required|ir_mobile|max:11',
            'brands'   => 'required|array',
            'brands.*'   => 'required|string|max:255',
            'brand_registration'     => 'nullable|numeric|in:0,1',
            'status'     => 'nullable|numeric|in:0,1',

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
