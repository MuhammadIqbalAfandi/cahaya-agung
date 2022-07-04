<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            "name" => "required|string|max:50",
            "address" => "required|string",
            "phone" =>
                "required|numeric|digits_between:12,15|unique:customers,phone," .
                $this->customer->id,
            "npwp" =>
                "required|numeric|digits_between:15,20|unique:customers,npwp," .
                $this->customer->id,
        ];
    }
}
