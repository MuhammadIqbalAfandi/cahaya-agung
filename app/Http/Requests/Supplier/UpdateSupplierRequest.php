<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'address' => 'required|string',
            'email' => 'required|string|email|unique:suppliers,email,' . $this->supplier->id,
            'phone' => 'required|numeric|digits_between:12,15|unique:suppliers,phone,' . $this->supplier->id,
            'npwp' => 'required|numeric|digits_between:15,20|unique:suppliers,npwp,' . $this->supplier->id
        ];
    }
}
