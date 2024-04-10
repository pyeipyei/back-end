<?php

namespace App\Services;

use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Database\Eloquent\Collection;

class DepartmentService
{
    public function __construct(private DepartmentRepository $departmentRepository)
    {
    }

    public function getAllEmployees(): Collection
    {
        return $this->departmentRepository->getAllEmployees();
    }

    public function getEmployeeById(int $id): Department
    {
        return $this->departmentRepository->getEmployeeById($id);
    }

    public function createDepartment(array $departmentData): Department
    {
        return $this->departmentRepository->createDepartment($departmentData);
    }

    public function updateDepartment(Department $department, array $departmentData): bool
    {
        return $this->departmentRepository->updateDepartment($department, $departmentData);
    }

    public function deleteDepartment(Department $department): void
    {
        $this->departmentRepository->deleteDepartment($department);
    }
}