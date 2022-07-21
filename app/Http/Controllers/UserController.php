<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $department['data'] = Department::orderby("department","asc")
        			   ->select('id','department')
        			   ->get();

    	return view('users.index')->with("department",$department);
    }

    public function allUsers(Request $request)
    {
        $columns = array(
            0 =>'id_number',
            1 =>'firstname',
            2 =>'lastname',
            3 =>'address',
            4 =>'mobile_no',
            5 => 'options'
        );

        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
        $output = User::offset($start)
                ->where('builtin',0)
                ->where('user_type','Users')
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value');

        $output =  User::where('builtin',0)
                    ->where('user_type','Users')
                    ->orWhere('lastname', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = User::where('builtin',0)
                    ->where('user_type','Users')
                    ->orWhere('lastname', 'LIKE',"%{$search}%")
                    ->with('department')
                    ->count();
        }

        $data = array();
        if(!empty($output))
        {
            foreach ($output as $value)
            {
                $nestedData['firstname'] = $value->firstname;
                $nestedData['lastname'] = $value->lastname;
                $nestedData['email'] = $value->email;
                $btn='';

                    $btn.= "<a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$value->id."' title='Edit' class='btn btn-default far fa-edit edit'></a>";

                    $btn.=  "&nbsp; <a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$value->id."' title='Delete' class='btn btn-danger delete fas fa-trash'></a>";

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

    public function allStaffs(Request $request)
    {
        $columns = array(
            0 =>'id_number',
            1 =>'firstname',
            2 =>'lastname',
            3 =>'address',
            4 =>'mobile_no',
            5 => 'options'
        );

        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
        $output = User::offset($start)
                ->where('builtin',0)
                ->where('user_type','Staff')
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value');

        $output =  User::where('builtin',0)
                    ->where('user_type','Staff')
                    ->orWhere('lastname', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = User::where('builtin',0)
                    ->where('user_type','Staff')
                    ->orWhere('lastname', 'LIKE',"%{$search}%")
                    ->with('department')
                    ->count();
        }

        $data = array();
        if(!empty($output))
        {
            foreach ($output as $value)
            {
                $nestedData['id_number'] = $value->id_number;
                $nestedData['firstname'] = $value->firstname;
                $nestedData['lastname'] = $value->lastname;
                $nestedData['department'] = $value->department;
                $btn='';

                    $btn.= "<a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$value->id."' title='Edit' class='btn btn-default far fa-edit edit'></a>";

                    $btn.=  "&nbsp; <a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$value->id."' title='Delete' class='btn btn-danger delete fas fa-trash'></a>";

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
    public function store(UserRequest $request)
    {
        // $request['password']=bcrypt($request['password']);
        // $request->user()->create($request->all());
        User::create([
            'id_number' => $request['id_number'],
            'user_type' => $request['user_type'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'address' => $request['address'],
            'mobile_no' => $request['mobile_no'],
            'department_id' => $request['department_id'],
            'password' => bcrypt($request['password']),
        ]);
        return response()->json(['success'=>'Data saved successfully.']);
        // dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(User::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        User::find($request->id)->update($request->all());

        return response()->json(['success' => 'Data is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success'=>'Record deleted successfully.']);
    }
}
