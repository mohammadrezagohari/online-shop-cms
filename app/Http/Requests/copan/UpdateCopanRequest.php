<?php

namespace App\Http\Requests\copan;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCopanRequest extends FormRequest
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
            'code'=>'nullable|string|max:255|min:3',
            'amount'=>'nullable|integer',
            'amount_type'=>'nullable|numeric|in:0,1',
            'discount_ceiling'=>'nullable|integer',
            'type'=>'nullable|numeric|in:0,1',
            'status'=>'nullable|numeric|in:0,1',
            'max_use_code'=>'nullable|integer',
            'start_date'=>'nullable|date|date_format:Y-m-d H:i:s',
            'end_date'=>'nullable|date|date_format:Y-m-d H:i:s',
            'user_id'=>'nullable|exists:users,id',
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
