<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Cache\RateLimiter;
use Carbon\Carbon;

class DepartmentRepository
{
    public function __construct(protected Department $department)
    {
    }

    private function getEmployeeService(): object|array
    {
        $limiter = app(RateLimiter::class);
        $actionKey = 'get_all_employees';
        $threshold = 10;
        try {
            if ($limiter->tooManyAttempts($actionKey, $threshold)) {
                return $this->failOrFallback();
            }
            return Http::EmployeeService()->get('/employees');
        } catch (\Exception $exception) {
            $limiter->hit($actionKey, Carbon::now()->addMinutes(15));
            return $this->failOrFallback();
        }
    }

    public function getAllEmployees(): Collection
    {
        try {
            DB::beginTransaction();
            $response = $this->getEmployeeService();
            $collection = collect($response["data"]);
            $departments = Department::orderBy('department_name', 'asc')->get();
            foreach ($departments as $department) {
                $department['marketing'] = $collection->where('emp_cd', $department["marketing_name"])->pluck('emp_name')->first();
                $department['leader'] = $collection->where('emp_cd', $department["department_head"])->pluck('emp_name')->first();
            }
            DB::commit();
            return $departments;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function failOrFallback()
    {
        return response()->json(['error' => 'Something went wrong.'], 500);
    }

    public function createDepartment(array $departmentData): Department
    {
        try {
            DB::beginTransaction();

            $department = Department::create([
                'department_name' => $departmentData['department_name'],
                'marketing_name' => $departmentData['marketing_name'],
                'department_head' => $departmentData['department_head'],
            ]);
            DB::commit();

            return $department;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getEmployeeById(int $id): Department
    {
        try {
            DB::beginTransaction();
            $response = $this->getEmployeeService();
            $collection = collect($response["data"]);
            $department = Department::find($id);
            $department['marketing'] = $collection->where('emp_cd', $department["marketing_name"])->pluck('emp_name')->first();
            $department['leader'] = $collection->where('emp_cd', $department["department_head"])->pluck('emp_name')->first();

            DB::commit();

            return $department;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateDepartment(Department $department, array $departmentData): bool
    {
        try {
            DB::beginTransaction();

            $department = $department->update([
                'department_name' => $departmentData['department_name'],
                'marketing_name' => $departmentData['marketing_name'],
                'department_head' => $departmentData['department_head'],
            ]);
            DB::commit();

            return $department;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteDepartment(Department $department): void
    {
        try {
            DB::beginTransaction();

            $department->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}