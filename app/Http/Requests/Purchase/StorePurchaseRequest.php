<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'number' => 'required|string|unique:sales,number',
            'status' => 'required|string',
            'price' => 'required|numeric',
            'qty' => 'required|numeric',
            'supplier_id' => 'required|numeric',
            'product_number' => 'required|string'
        ];
    }
}