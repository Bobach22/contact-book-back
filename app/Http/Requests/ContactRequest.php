<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name'=>'required|string|unique:contacts,name|min:3',
            'emails'=>'required|array|min:1',
            'phones'=>'required|array|min:1',
            'emails.*.email'=>'required|email|distinct|unique:emails',
            'phones.*.phone'=>'required|string|distinct|min:7|unique:phones'
        ];
    }
}
