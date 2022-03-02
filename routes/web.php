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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('employeelist', [App\Http\Controllers\EmployeeController::class, 'employeelist'])->name('employeelist');
Route::get('employeeregistration', [App\Http\Controllers\EmployeeController::class, 'employeeregistration'])->name('employeeregistration');

Route::get('ajaxemployeelist', [App\Http\Controllers\EmployeeController::class, 'ajaxemployeelist'])->name('ajaxemployeelist');


Route::post('add_employee', [App\Http\Controllers\EmployeeController::class, 'add_employee'])->name('add_employee');
Route::post('employee_details', [App\Http\Controllers\EmployeeController::class, 'employee_details'])->name('employee_details');
Route::post('employee_update', [App\Http\Controllers\EmployeeController::class, 'employee_update'])->name('employee_update');
Route::post('employee_delete', [App\Http\Controllers\EmployeeController::class, 'employee_delete'])->name('employee_delete');

