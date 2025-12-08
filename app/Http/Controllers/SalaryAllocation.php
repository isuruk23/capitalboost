<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Investment;
use App\JobTitle;
use App\JobCategory;
use App\SalaryAdjustment;
use App\PayrollProfile;


class SalaryAllocation extends Controller
{
     public function payallocation()
    {
        $user = Auth::user();
        $permission = $user->can('payallocation');
        if(!$permission){
            abort(403);
        }

        return view('Payroll.payallocation.salaryallocationapprovel');
    }

    public function get_employee_allocation(Request $request)
    {
        $department = Request('department');
        $employee = Request('employee');
        $location = Request('location');
        $month = Request('month');

         $emp_query = 'SELECT  
                employees.*,  
                branches.location,
                departments.name as dept_name 
                FROM `employees`   
                left join branches ON employees.emp_location = branches.id 
                left join departments ON employees.emp_department = departments.id 
                WHERE employees.deleted = 0  
                ';

        if($department != ''){
            $emp_query .= ' AND employees.emp_department = '.$department;
        }

        if($employee != ''){
            $emp_query .= ' AND employees.emp_id = '.$employee;
        }

        if($location != ''){
            $emp_query .= ' AND employees.emp_location = '.$location;
        }
         $records = DB::select($emp_query);


          $data_arr = array();

            foreach ($records as $record) {

                $monthlyinvesttarget = Investment::where('created_at', 'like', $month.'%')
                    ->where('sales_by', $record->emp_id)
                    ->sum('initial_investment');

                $jobtarget = JobTitle::where('id', $record->emp_job_code)->pluck('target')->first();
                $target80 = $jobtarget * 0.8;

                // Base employee data (always pushed)
                $emp_data = array(
                    "uid" => $record->emp_id,
                    "emp_etfno" => $record->emp_etfno,
                    "emp_name_with_initial" => $record->emp_name_with_initial,
                    "emp_location" => $record->location,
                );

                // Check if employee reached 80% of target
                if ($monthlyinvesttarget >= $target80) {
                    $allowance = SalaryAdjustment::where('job_id', $record->job_category_id)
                        ->whereIn('remuneration_id', [21, 29])
                        ->get()
                        ->keyBy('remuneration_id');

                    $vehicle = $allowance->get(21);
                    $fuel = $allowance->get(29);

                    // Add allowances to employee data
                    $emp_data["vehicle_allowance"] = $vehicle ? $vehicle->amount : 'Not Complete the Target';
                    $emp_data["fuel_allowance"] = $fuel ? $fuel->amount : 'Not Complete the Target';
                } 
             

               $basic = PayrollProfile::where('emp_id', $record->emp_id)->pluck('basic_salary')->first();
                $emp_data["basic"] = $basic ? $basic : 'Not Set the Basic on profile';

                $data_arr[] = $emp_data;
            }


         return response()->json([
            'data' => $data_arr,
        ]);
      
    }
}
