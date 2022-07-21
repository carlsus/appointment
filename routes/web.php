<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('users', 'UserController');
Route::get('allUsers', 'UserController@allUsers' )->name('allUsers');
Route::get('allStaffs', 'UserController@allStaffs' )->name('allStaffs');
Route::post('users/update', 'UserController@update')->name('users.update');
Route::resource('staffs', 'StaffController');
Route::resource('registration', 'RegistrationController');


Route::resource('departments', 'DepartmentController');
Route::get('allDepartments', 'DepartmentController@allDepartments' )->name('allDepartments');
Route::post('departments/update', 'DepartmentController@update')->name('departments.update');
Route::get('getDepartment', 'DepartmentController@getDepartment' )->name('getDepartment');

Route::resource('dashboard','DashboardController');

Route::resource('students','StudentController');
Route::resource('appointments', 'AppointmentController');
//Route::get('appointments/{id}', 'AppointmentController@show' );
Route::get('myappointment', 'AppointmentController@myappointment' )->name('myappointment');
Route::post('appointments/update', 'AppointmentController@update')->name('appointments.update');

Route::resource('qrscan', 'QrScanController');

Route::get('showappointment', 'AppointmentController@showappointment' )->name('showappointment');
Route::get('staffappointment', 'AppointmentController@staffappointment' )->name('staffappointment');

Route::patch('appointments/updateStatus/{id}', 'AppointmentController@updateStatus');
Route::patch('appointments/rejectStatus/{id}', 'AppointmentController@rejectStatus');


Route::get('sendmessage/{id}', 'SMSController@sendmessage')->name('sendmessage');
Route::get('send_to_staff/{id}', 'SMSController@send_to_staff')->name('send_to_staff');
Route::get('send_to_student/{id}', 'SMSController@send_to_student')->name('send_to_student');




