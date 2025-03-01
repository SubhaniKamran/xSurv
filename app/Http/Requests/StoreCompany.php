<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompany extends FormRequest
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
            'company_name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|same:confirm_password|min:5',
            'confirm_password' =>'required',
            'address'=>'required',
            'phone'=>'required',
        ];
    }
}
