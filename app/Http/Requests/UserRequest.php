<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'user_type' => 'required',
            'id_number' => 'required|unique:users,id_number,' .$this->id,
            'firstname' => 'required',
            'lastname' => 'required',
            'mobile_no' => 'required|unique:users,mobile_no,' .$this->id,
            'email' => 'required|email:rfc|unique:users,email,' .$this->id,
            'department_id' => 'required|exists:departments,id',
            'password' => 'required'

        ];
    }
    public function attributes()
    {
        return [
            'user_type' => 'Type',
            'id_number' => 'ID Number',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email Address',
            'mobile_no' => 'Mobile Number',
            'department_id' => 'Department',
            'password' => 'Password'
        ];
    }
}
