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
            "name" => "required|string|max:50",
            "address" => "required|string|max:200",
            "telephone" => "required|numeric|digits_between:4,20",
            "email" => "string|email|nullable",
            "npwp" => "required|numeric|digits_between:15,20",
        ];
    }
}
