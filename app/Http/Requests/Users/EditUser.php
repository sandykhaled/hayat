<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class EditUser extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
            'name' => 'required',
            'photo' => 'nullable|image',
            'email' => 'nullable|email|unique:users,email,'.$this->id,
            'phone' => 'required|numeric|unique:users,phone,'.$this->id,
            'another_phone' => 'required|numeric|unique:users,another_phone,'.$this->id
        ];
    }
}
