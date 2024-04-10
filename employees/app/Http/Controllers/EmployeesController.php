<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Response;
class EmployeesController extends Controller
{
    public function __construct(private EmployeeService $employeeService) {}

    public function index()
    {
        try{
        $employees = $this->employeeService->getEmployeeList();
        $meta = ["status"=>200,"msg"=>"Success"];
        return response()->json(
            [
                'meta' => $meta,
                'data' => $employees,
            ]
        );
          } catch (\Exception $e) {
            // Handle exceptions and errors
            return Response::error($e->getMessage(), 500);
        }
      
    }
   
    public function search()
    {
        try{
          $employees = $this->employeeService->searchEmployee();
            $meta = ["status"=>200,"msg"=>"Success"];
            return response()->json(
             [
                'meta' => $meta,
                'data' => $employees,
                ]
            );
         } catch (\Exception $e) {
            // Handle exceptions and errors
            return Response::error($e->getMessage(), 500);
        }
    }

    public function show(String $employeeCode)    
    {
        $employeeId = $this->employeeService->getEmployeesByEmployeeCode($employeeCode);
        return response()->json($employeeId, 200);        
    }

    public function create(Request $request)
    {
        $employees = $this->employeeService->create($request);
        $meta = ["status"=>200,"msg"=>"Success"];
        return response()->json(
            [
                'meta' => $meta,
                'data' => $employees,
            ]
        );
    }
    
    public function update(String $emp_cd,Request $request)
    {
        $employees = $this->employeeService->update($emp_cd,$request);
        $meta = ["status"=>200,"msg"=>"Success"];
        return response()->json(
            [
                'meta' => $meta,
                'data' => $employees,
            ]
        );
    }
    
    public function delete(String $emp_cd)
    {
        $employees = $this->employeeService->delete($emp_cd);
        $meta = ["status"=>200,"msg"=>"Success"];
        return response()->json(
            [
                'meta' => $meta,
                'data' => $employees,
            ]
        );
    }
}
