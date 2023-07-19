<?php

namespace App\Http\Requests\RoleManagement;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    /**
     * Determine if the menu is authorized to make this request.
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
            'name'      => ['required', 'max:150'],
            'id_parent' => ['required'],
            'order'     => ['required', 'numeric'],
            'is_active' => ['required', 'numeric'],
        ];

        return $returns;
    }

}
