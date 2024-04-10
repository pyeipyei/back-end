<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;

class EmployeeService
{
    public function __construct(private EmployeeRepository $employeeRepository) {}
   
    public function getEmployeeList()
    {
        return $this->employeeRepository->getEmployeeList();
    }

    public function getEmployeesByEmployeeCode($employeeCode)
    {
        return $this->employeeRepository->getEmployeesByEmployeeCode($employeeCode);
    }

    function searchEmployee()
    {
        return $this->employeeRepository->searchEmployee();
    }

    public function create($request)
    {
        return $this->employeeRepository->create($request);
    }

    public function update($emp_cd, $request)
    {
        return $this->employeeRepository->update($emp_cd, $request);
    }

    public function delete($emp_cd)
    {
        return $this->employeeRepository->delete($emp_cd);
    }
}