<?php

namespace App\Http\Controllers;

use App\Events\EngineerEvent;
use App\Http\Controllers\Controller;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function __construct(private EmployeeService $employeeService)
    {
    }

    public function index()
    {
        try {
            $response = $this->employeeService->getAllEmployee();
            $result[0] = 'Selected';
            $result[1] = 'Engineer List Data';
            event(new EngineerEvent($result));
            return $response;
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $filter = $request->query('filter', []);
            $response = $this->employeeService->searchEmployee($filter);
            $result[0] = 'Searched';
            $result[1] = 'Engineer Data  by emp_name';
            event(new EngineerEvent($result));
            return $response;
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }
}
