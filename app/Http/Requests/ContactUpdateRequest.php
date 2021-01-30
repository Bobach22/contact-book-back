<?php

namespace App\Http\Requests;

use App\Models\Email;
use App\Models\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class ContactUpdateRequest extends FormRequest
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
        $rules = [
            'name' => ['required','string','min:3',Rule::unique('contacts','name')->ignore($this->route('contact'))],
            'emails' => 'required|array|min:1',
            'phones' => 'required|array|min:1',
            'emails.*.email' => ['required', 'email', 'distinct', function ($attribute, $value, $fail) {
                foreach ($this->get('emails') as $email) {
                    if (isset($email['email']) && $email['email'] === $value) {
                        $foundEmail=Email::where('email', $value)->first();
                        if($foundEmail&&$foundEmail->id!=$email['id']){
                            $fail('Email already taken');
                        }
                    }
                }
            }],
            'phones.*.phone' => ['required','string','min:7','distinct', function ($attribute, $value, $fail) {
                foreach ($this->get('phones') as $phone) {
                    if (isset($phone['phone']) && $phone['phone'] === $value) {
                        $foundPhone=Phone::where('phone', $value)->first();
                        if($foundPhone&&$foundPhone->id!=$phone['id']){
                            $fail('Phone already taken');
                        }
                    }
                }
            }],
        ];

        return $rules;
    }

}
