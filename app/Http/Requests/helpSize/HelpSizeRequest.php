<?php

namespace App\Http\Requests\helpSize;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HelpSizeRequest extends FormRequest
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
            'size'   => 'nullable|string',
            'height'     => 'nullable|string',
            'Waist'     => 'nullable|string',
            'sleeveـlength'     => 'nullable|string',
            'product_id'     => 'nullable|string|exists:products,id',
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
