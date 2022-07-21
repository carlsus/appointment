<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
class SMSController extends Controller
{

    public function sendmessage($id){
        // $pollwatchers = PollWatcher::whereNotNull('mobileno')->get();
        // foreach ($pollwatchers as $pw ) {
        //     $receiverNumber = '+63' . $pw->mobileno;
        //     $message = $request->message;

        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create('+639177402785', [
                'from' => $twilio_number,
                'body' => 'samplddde' . $id]);



        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }

    }
    public function send_to_staff($id){
        $appointment = Appointment::find($id);
        $student=User::find($appointment->student_id);
        $staff=User::find($appointment->staff_id);
        $message=$student->fistname .' ' .$student->lastname . ' ' . 'is setting an appointment to you on ' . $appointment->appointment_date_start;
        // foreach ($pollwatchers as $pw ) {
        //     $receiverNumber = '+63' . $pw->mobileno;
        //     $message = $request->message;

        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($staff->mobile_no, [
                'from' => $twilio_number,
                'body' => $message]);



        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }

    }

    public function send_to_student($id){
        $appointment = Appointment::find($id);
        $student=User::find($appointment->student_id);
        $staff=User::find($appointment->staff_id);
        $message='Your appointment to ' . $staff->firstname . ' ' . $staff->lastname .' ' . 'on ' . $appointment->appointment_date_start . ' has been approved';
        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($student->mobile_no, [
                'from' => $twilio_number,
                'body' => $message]);



        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }

    }
}
