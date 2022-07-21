<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $department['data'] = Department::orderby("department","asc")
        ->select('id','department')
        ->get();

        return view('registration.index')->with("department",$department);
    }

}
