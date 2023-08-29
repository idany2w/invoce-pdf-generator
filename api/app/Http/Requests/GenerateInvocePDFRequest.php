<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateInvocePDFRequest extends FormRequest
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
            'supplier.logo' => 'required|image|max:32000',
            
            'supplier.name' => 'required|string|max:255',
            'supplier.inn' => 'required|string|max:30|not_regex:/\D/',
            'supplier.kpp' => 'required|string|max:30|not_regex:/\D/',
            'supplier.address' => 'required|string|max:512',

            'client.fullName' => 'required|string|max:255',
            'client.inn' => 'required|string|max:30|not_regex:/\D/',
            'client.address' => 'required|string|max:512',

            'products' => 'array|required',
            'products.*.name' => 'required|string|max:255',
            'products.*.quantity' => 'required|integer',
            'products.*.price' => 'required|numeric',
        ];
    }
}
