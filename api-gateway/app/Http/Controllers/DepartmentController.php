<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentFormRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Support\Facades\Response;
use App\Events\DepartmentEvent;

class DepartmentController extends Controller
{
    public function __construct(private DepartmentService $departmentService)
    {
    }

    public function index()
    {
        $departmentsWithEmployee = $this->departmentService->getAllEmployees();
        $department[0] = 'Selected';
        $department[1] = 'Department List Data';
        event(new DepartmentEvent($department));
        return new DepartmentResource($departmentsWithEmployee);
    }

    public function store(DepartmentFormRequest $request)
    {
        $departmentData = [
            'department_name' => $request->input('department_name'),
            'marketing_name' => $request->input('marketing_name'),
            'department_head' => $request->input('department_head'),
        ];

        $department = $this->departmentService->createDepartment($departmentData);
        $result[0] = 'Created';
        $result[1] = $department->department_name;
        event(new DepartmentEvent($result));
        return Response::success('Success', 200, []);
    }

    public function edit(int $id)
    {
        $departmentWithEmployee = $this->departmentService->getEmployeeById($id);

        return new DepartmentResource($departmentWithEmployee);
    }

    public function update(DepartmentFormRequest $request, Department $department)
    {
        $departmentData = [
            'department_name' => $request->input('department_name'),
            'marketing_name' => $request->input('marketing_name'),
            'department_head' => $request->input('department_head'),
        ];

        $this->departmentService->updateDepartment($department, $departmentData);
        $result[0] = 'Updated';
        $result[1] = $department->department_name;
        event(new DepartmentEvent($result));
        return Response::success('Success', 200, []);
    }

    public function destroy(Department $department)
    {
        $this->departmentService->deleteDepartment($department);
        $result[0] = 'Deleted';
        $result[1] = $department->department_name;
        event(new DepartmentEvent($result));
        return Response::success('Success', 200, []);
    }
}
