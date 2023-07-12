<?php

namespace App\Http\Requests\address;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'keyword'   => 'nullable|string|max:30',
            'count'     => 'nullable|numeric',
            'user_id'     => 'nullable|exists:users,id',
        ];
    }
}
