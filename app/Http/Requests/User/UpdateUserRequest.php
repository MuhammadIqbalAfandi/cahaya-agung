<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|max:50",
            "username" =>
                "required|string|regex:/^\S*$/u|min:6|max:25|unique:users,username," .
                $this->user->id,
            "role_id" => "required|numeric",
        ];
    }
}
