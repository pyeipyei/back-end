<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;
use Illuminate\Http\Client\Response;

class EmployeeService
{
    public function __construct(private EmployeeRepository $employeeRepository) {}

    public function getAllEmployee(): Response
    {
        return $this->employeeRepository->getAllEmployee();
    }

    public function searchEmployee(array $filter): Response
    {
        return $this->employeeRepository->searchEmployee($filter);
    }

}
