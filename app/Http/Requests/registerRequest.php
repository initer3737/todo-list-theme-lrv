<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registerRequest extends FormRequest
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
            'username'=>['required','string','unique:users,username','min:6'],
            'email'=>['required','email','unique:users,email'],
            'country'=>['required','min:5','string'],
            'gender'=>['required','min:0','max:6','string'],
            'password'=>['required','min:5'],
            'password_confirm'=>['required','same:password']
        ];
    }
}
