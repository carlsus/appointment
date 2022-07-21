<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded=[];
    protected $dates = ['appointment_date_start','appointment_date_end'];


    public function setAppointmentDateStart($value) {
        $this->attributes['appointment_date_start'] = Carbon::createFromFormat('d-m-Y H:i:s', $value)->format('Y-m-d');
    }

    public function setAppointmentDateEnd($value) {
        $this->attributes['appointment_date_end'] = Carbon::createFromFormat('d-m-Y H:i:s', $value)->format('Y-m-d');
    }


}
