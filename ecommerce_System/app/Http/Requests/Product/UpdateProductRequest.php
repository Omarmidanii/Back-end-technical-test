<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'string|min:3|max:255',
            'lastname' => 'string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'numeric|min:0.01',
            'quantity' => 'integer|min:0',
        ];
    }
}
