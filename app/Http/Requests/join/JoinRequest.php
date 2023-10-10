<?php

namespace App\Http\Requests\join;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class JoinRequest extends FormRequest
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
            'first_name'   => 'nullable|string',
            'last_name'   => 'nullable|string',
            'email'   => 'nullable|string',
            'company_name'   => 'nullable|string',
            'referral_code'   => 'nullable|string',
            'mobile'   => 'nullable|string',
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
