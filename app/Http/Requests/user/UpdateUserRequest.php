<?php

namespace App\Http\Requests\user;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'mobile'=>'nullable|string|max:11|unique:users',
            'password'=>['nullable',Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'avatar'=>'nullable|numeric|in:0,1',
            'national_code'=>'nullable|string|digits:10|unique:users',
            'first_name'=>'nullable|string|max:255',
            'last_name'=>'nullable|string|max:255',
            'user_type'=>'nullable|numeric|in:0,1',
            'status'=>'nullable|numeric|in:0,1',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
