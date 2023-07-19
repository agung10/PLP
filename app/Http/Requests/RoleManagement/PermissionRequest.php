<?php

namespace App\Http\Requests\RoleManagement;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the permission is authorized to make this request.
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

        $returns = [
            'permission_name'   => ['required', 'max:150'],
            'permission_action' => ['required', 'max:150'],
            'description'       => ['required', 'max:255'],
        ];

        return $returns;
    }

}
