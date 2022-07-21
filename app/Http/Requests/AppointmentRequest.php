<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
            'appointment_date_start' => 'required',
            'student_id' => 'required|exists:users,id',
            'staff_id' => 'required|exists:users,id',
        ];
    }

    public function attributes()
    {
        return [
            'appointment_date_start' => 'Appointment Start Date',
            'staff_id' => 'Staff',
        ];
    }
}
