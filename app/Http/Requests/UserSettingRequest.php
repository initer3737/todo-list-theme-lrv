<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSettingRequest extends FormRequest
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
            'username'=>['unique:users,username','min:6','nullable'],
            'avatar'=>['nullable','file','mimes:png,jpg','image'],
            'country'=>['min:6','string','nullable'],
            'status'=>['string','min:6','nullable'],
            'gender'=>['min:0','max:6'],
            'name'=>['string','min:6','nullable'],
            'password'=>['required','min:5'],
            'password_confirm'=>['required','same:password']
        ];
    }
}
