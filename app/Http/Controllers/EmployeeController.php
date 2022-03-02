<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Support\Str;
use App\Mail\EmployeeRegistartion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    public function employeelist(){
        if (Auth::id() == "") {
            return view('auth.Login');
        } else {
            $designations = Designation::get();
            return view('Admin.employeelist')->with(['designations' => $designations]);
        }
    }

    public function ajaxemployeelist(){ 
        $data = Employee::get();
        $object = array();
        foreach($data as $employee){
            array_push($object ,[
                "employee_id" => $employee->employee_id,
                "employee_name" => $employee->employee_name,
                "employee_email" => $employee->employee_email,
                "designation_name" => $employee->designation->designation_name,
            ]); 
        }
        return Datatables::of($object)->make(true);
    }

    public function employeeregistration(){
        if (Auth::id() == "") {
            return view('auth.Login');
        } else {
            $designations = Designation::get();
            return view('Admin.employeeregistration')->with(['designations' => $designations]);
        }
    }

    public function add_employee(Request $request, Employee $employee){
        $validator = Validator::make($request->all(), [
            'employee_name' => 'required',
            'employee_email' => 'required|unique:employees',
            'employee_image' => 'image|mimes:jpeg,png,jpg|max:5120',
            'designation_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 202]);
        } else {
            try{
                $image = $request->file('employee_image');
                if ($image == "") {
                    $new_name = "";
                } else {
                    $new_name = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('Images'), $new_name);
                }
                $employee->employee_name = $request->employee_name;
                $employee->employee_email = $request->employee_email;
                $employee->image_path = $new_name;
                $employee->designation_id = $request->designation_id;
                if ($employee->save()) {
                    $employee->password = Str::random(15);
                    Mail::to($employee->employee_email)->send(new EmployeeRegistartion($employee));
                    return response()->json(['message' => 'Employee Added Successfully', 'status' => 201]);
                } else {
                    return response()->json(['message' => 'Someting Went Wrong', 'status' => 202]);
                }
            }catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage(), 'status' => 202]);
            }

        }

    }

    public function employee_details(Request $request){
        return Employee::find($request->employee_id);
    }

    public function employee_update(Request $request){
        $validator = Validator::make($request->all(), [
            'employee_name' => 'required',
            'employee_email' => 'required',
            'employee_image' => 'image|mimes:jpeg,png,jpg|max:5120',
            'designation_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 202]);
        } else {
            try{
                $employee = Employee::find($request->employee_id);
                $image = $request->file('employee_image');
                if ($image == "") {
                    $new_name = "";
                } else {
                    $new_name = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('Images'), $new_name);
                    $employee->image_path = $new_name;
                }
                $employee->employee_name = $request->employee_name;
                $employee->employee_email = $request->employee_email;
                $employee->designation_id = $request->designation_id;
                if ($employee->save()) {
                    return response()->json(['message' => 'Employee Updated Successfully', 'status' => 201]);
                } else {
                    return response()->json(['message' => 'Someting Went Wrong', 'status' => 202]);
                }
            }catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage(), 'status' => 202]);
            }

        }
    }

    public function employee_delete(Request $request){
        if(Employee::find($request->employee_id)->delete()){
            return response()->json(['message' => 'Employee Deleted Successfully', 'status' => 201]);
        }else{
            return response()->json(['message' => 'Someting Went Wrong', 'status' => 202]);
        }
    }

    
}
