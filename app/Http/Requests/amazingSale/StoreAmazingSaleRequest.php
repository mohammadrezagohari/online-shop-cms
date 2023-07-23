<?php

namespace App\Http\Requests\amazingSale;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAmazingSaleRequest extends FormRequest
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
           'product_id'=>'required|exists:products,id',
           'percentage'=>'required|numeric|min:1|max:100',
           'status'=>'nullable|numeric|in:0,1',
           'start_date'=>'required|date|date_format:Y-m-d H:i:s',
           'end_date'=>'required|date|date_format:Y-m-d H:i:s',
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
