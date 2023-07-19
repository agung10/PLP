<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembayaranRequest extends FormRequest
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
        $admin = \Auth::user()->user_id == 1;
        
        if ($admin) {
            return [
                'pelanggan_id'   => ['required'],
                'biaya_admin'    => ['required'],
                'total_bayar'    => ['required'],
            ];
        } else {
            return [
                'pelanggan_bayar' => ['required'],
            ];
        }
    }

}
