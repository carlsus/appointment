<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class StaffController extends Controller
{
     public function index()
    {

        $department['data'] = Department::orderby("department","asc")
        			   ->select('id','department')
        			   ->get();

    	return view('staffs.index')->with("department",$department);
    }

}
