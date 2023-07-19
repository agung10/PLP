<?php

namespace App\Http\Requests\RoleManagement;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordRequest extends FormRequest
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
        $user_id = ($this->UserPassword) ? $this->UserPassword : 0;

        $returns = [
            'username' => $this->UserPassword ?
                            ['required', 'alpha_dash', 'max:150', 'unique:user,username,'. $this->UserPassword .',user_id']
                            :
                            ['required', 'alpha_dash', 'max:150', 'unique:user,username'],

            'email'    => $this->UserPassword ?
                            ['required','email', 'max:150', 'unique:user,email,'.$user_id.',user_id']
                            :
                            ['required','email', 'max:150', 'unique:user,email'],
            'role'     => ['required'],
            'password' => $this->UserPassword ?
                            ['nullable','string','min:6','confirmed']
                            :
                            ['required','string','min:6','confirmed'],
        ];

        return $returns;
    }

}
