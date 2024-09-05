<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;

class EditClient extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
            'Name' => 'required',
            'service_id' => 'nullable',
            'code' => 'nullable|string|max:255',
            'referral' => 'nullable|string',
        ];
    }
}
