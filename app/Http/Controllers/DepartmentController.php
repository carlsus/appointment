<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function allDepartments(Request $request)
    {
        $columns = array(
            0 =>'department',
            1 =>'options'
        );

        $totalData = Department::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
        $departments = Department::offset($start)
        ->where('builtin',0)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value');

        $departments =  Department::where('department','LIKE',"%{$search}%")
        ->where('builtin',0)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        $totalFiltered = Department::where('department','LIKE',"%{$search}%")
                    ->count();
        }

        $data = array();
        if(!empty($departments))
        {
            foreach ($departments as $department)
            {


                $nestedData['department'] = $department->department;
                $btn='';

                    $btn.= "<a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$department->id."' title='Edit' class='btn btn-default far fa-edit edit'></a>";

                    $btn.=  "&nbsp; <a href='javascript:void(0)' data-toggle='tooltip'  data-id='".$department->id."' title='Delete' class='btn btn-danger delete fas fa-trash'></a>";

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('departments.index');
    }

    public function getDepartment()
    {
        return response()->json(Department::select('id','department')->orderBy('department','asc')->get());
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        $request->user()->department()->create($request->all());
        return response()->json(['success'=>'Data saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::find($id);
        return response()->json($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request)
    {
        Department::findOrFail($request->id)->update($request->all());

        return response()->json(['success' => 'Data is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Department::find($id)->delete();
        return response()->json(['success'=>'Data deleted successfully.']);
    }
}
