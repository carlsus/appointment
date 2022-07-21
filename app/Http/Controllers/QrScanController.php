<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QrScanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('scan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $output = Appointment::where('qr',$id)->first();
        $staff=User::where("id",$output->staff_id)->first();
        $student=User::where("id",$output->student_id)->first();

        $start_date = Carbon::parse($output->appointment_date_start)->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($output->appointment_date_end)->format('Y-m-d H:i:s');
        $time = Carbon::parse($output->appointment_date_start)->toTimeString();
        $status='nosched';
        if($start_date <= Carbon::now() && $end_date >=Carbon::now()){
           $status='withsched';
        }
        $data = array(
            "appointment_date_start" => $output->appointment_date_start,
            "appointment_date_end" => $output->appointment_date_end,
            "staff_name" => $staff->firstname . ' ' .$staff->lastname,
            "student_name" => $student->firstname. ' ' .$student->lastname,
            'status' =>$status
          );
          return json_encode($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
