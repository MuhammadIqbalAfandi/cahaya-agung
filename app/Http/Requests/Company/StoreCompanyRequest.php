<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            "name" => "required|string|max:25",
            "address" => "required|string",
            "telephone" =>
                "required|numeric|digits_between:10,15|unique:companies,telephone," .
                $this->id,
            "email" =>
                "string|email|nullable|unique:companies,email," . $this->id,
            "npwp" =>
                "required|numeric|digits_between:15,20|unique:companies,npwp," .
                $this->id,
        ];
    }
}
