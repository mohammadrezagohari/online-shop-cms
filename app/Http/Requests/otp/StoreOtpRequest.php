<?php

namespace App\Http\Requests\otp;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOtpRequest extends FormRequest
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
            'user_id'=>'required|exists:users,id',
            'otp_code'=>'required|string',
            'login_id'=>'required|string|in:0,1',
            'type'=>'required|string|in:0,1',
            'used'=>'required|string|in:0,1',
            'status'=>'required|string|in:0,1'
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
