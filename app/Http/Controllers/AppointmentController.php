<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\AppointmentRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department['data'] = User::orderby("lastname","asc")
        ->where('user_type', "Staff")
        ->select('id','firstname','lastname')
        ->get();

        return view('students.index')->with("department",$department);
    }

    public function showAppointment(){
        return view('staffs.appointments');
    }

    public function staffappointment(Request $request)
    {
        $columns = array(
            0 =>'student_id',
            1 =>'appointment_date_start',
            2 =>'appointment_date_end',
            3 =>'status',
            4 => 'options'
        );

        $totalData = Appointment::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
        $output = Appointment::offset($start)
                ->where('staff_id', Auth::user()->id )

                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value');

        $output =  Appointment::where('staff_id', Auth::user()->id )
                    ->orWhere('lastname', 'LIKE',"%{$search}%")

                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = Appointment::where('staff_id', Auth::user()->id )
                    ->orWhere('lastname', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($output))
        {
            foreach ($output as $value)
            {
                $lastname=User::where("id",$value->student_id)
                ->select('id','firstname','lastname')->first();
                $firstname=$lastname->firstname;
                $nestedData['student_name'] =$firstname .' '.$lastname->lastname;
                $nestedData['appointment_date_start'] = $value->appointment_date_start;
                $nestedData['appointment_date_end'] = $value->appointment_date_end;
                $nestedData['status'] = $value->status;
                $nestedData['qr'] = $value->qr;
                $btn='';

                    $btn.= "<a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$value->id."' title='Approve' class='btn btn-default fas fa-check approve'></a>";
                    $btn.=  "&nbsp; <a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$value->id."' title='Decline' class='btn btn-danger decline fas fa-ban'></a>";
                    // $btn.=  "&nbsp; <a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$value->qr."' title='View QR Code' class='btn btn-primary view fas fa-eye'></a>";


                $nestedData['options']=$btn;


                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
            );

        echo json_encode($json_data);
    }

    public function myappointment(Request $request)
    {
        $columns = array(
            0 =>'id',
            1 =>'appointment_date_start',
            2 =>'appointment_date_end',
            3 =>'status',
            4 => 'options'
        );

        $totalData = Appointment::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
        $output = Appointment::offset($start)
                ->where('student_id', Auth::user()->id )

                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value');

        $output =  Appointment::where('student_id', Auth::user()->id )
                    ->orWhere('lastname', 'LIKE',"%{$search}%")

                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = Appointment::where('student_id', Auth::user()->id )
                    ->orWhere('lastname', 'LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($output))
        {
            foreach ($output as $value)
            {

                // $nestedData['staff_name'] = $value->users->firstname . ' ' . $value->users->lastname;
                $lastname=User::where("id",$value->staff_id)
                ->select('id','firstname','lastname')->first();
                $firstname=$lastname->firstname;
                $nestedData['staff_name'] =$firstname .' '.$lastname->lastname;
                $nestedData['appointment_date_start'] = $value->appointment_date_start;
                $nestedData['appointment_date_end'] = $value->appointment_date_end;
                $nestedData['status'] = $value->status;
                $nestedData['qr'] = $value->qr;
                $btn='';

                    $btn.= "<a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$value->id."' title='Edit' class='btn btn-default far fa-edit edit'></a>";
                    $btn.=  "&nbsp; <a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$value->id."' title='Delete' class='btn btn-danger delete fas fa-trash'></a>";
                     $btn.=  "&nbsp; <a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$value->qr."' title='View QR Code' class='btn btn-primary view fas fa-eye'></a>";

                $nestedData['options']=$btn;


                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
            );

        echo json_encode($json_data);
    }
    /*
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
    public function store(AppointmentRequest $request)
    {
        $date = Carbon::parse($request['appointment_date_start'])->addHour();

        $request['appointment_date_end']=$date;
        $data=Appointment::create([
            'student_id' => $request['student_id'],
            'staff_id' => $request['staff_id'],
            'appointment_date_start' => $request['appointment_date_start'],
            'appointment_date_end' => $date,

        ]);

        return response()->json(['success'=>'Data saved successfully.','id' => $data->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $qr['data'] =$id;


        return view('view')->with("qr",$qr);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $output = Appointment::where('qr',$id)->get();
    //     return response()->json($output);
    // }
    public function updateStatus($id){

        $filename=Str::random(40);
//         QrCode::size(500)
//                 ->format('png')
//                 ->generate($filename, public_path('img/qrcode.png'));

// //         $image = QrCode::format('png')
// //                  ->merge('img/t.png', 0.1, true)
// //                  ->size(200)->errorCorrection('H')
// //                  ->generate($filename);
// // $output_file = '/img/' . $filename . '.png';
// // Storage::disk('local')->put($output_file, $image); //storage/app/public/img/qr-code/img-1557309130.png
//       //  $path = Storage::path('file.jpg');
//        //QrCode::size(250)->generate($filename,'./public/storage/img/'. $filename . '.svg');
//         // $image = QrCode::format('png')
//         //          ->size(200)->errorCorrection('H')
//         //          ->generate($filename);
//         //         $output_file = '/img/qr-code/' . $filename . '.png';
//         //         Storage::disk('public')->put($output_file, $image); //storage/app/public/img/qr-code/img-1557309130.png
        // QrCode::size(250)

        // ->generate($filename, public_path('/storage/img/'. $filename . '.svg'));
        $update=Appointment::find($id);
        $update->qr=$filename;
        $update->status='Approved';
        $update->save();
        return json_encode(array('statusCode'=>200));
        //dd($output_file);
    }

    public function rejectStatus($id){



        $update=Appointment::find($id);
        $update->qr=null;
        $update->status='Rejected';
        $update->save();
        return json_encode(array('statusCode'=>200));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Appointment::find($id)->delete();
        return response()->json(['success'=>'Record deleted successfully.']);
    }
}
