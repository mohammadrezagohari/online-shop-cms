<?php

namespace App\Http\Requests\delivery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryRequest extends FormRequest
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
            'name'=>'nullable|string|max:255|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'amount'=>'nullable|integer',
            'delivery_time'=>'nullable|integer',
            'delivery_time_unit'=>'nullable|string|max:255',
            'status'=>'nullable|numeric|in:0,1',
        ];
    }
}
