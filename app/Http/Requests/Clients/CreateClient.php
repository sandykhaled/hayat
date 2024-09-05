<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;

class CreateClient extends FormRequest
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
            'service_id' => 'required',
            'code' => 'string|max:255',
            'referral' => 'string',
        ];
    }
}
