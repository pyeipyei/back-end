<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class EmployeeRepository
{
    public function __construct(protected Employee $employee)
    {
    }

    public function getEmployeeList()
    {
        try {
            DB::beginTransaction();
            $employees = collect(Employee::orderBy('emp_name', 'asc')->get())->map(function ($employee) {
                $employee['location'] = 'Japan';
                return $employee;
            })->all();
            DB::commit();
            return $employees;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getEmployeesByEmployeeCode($employeeCode)
    {
        try {
            DB::beginTransaction();
            $employees = DB::table('employeemaster')->select('*')->where('emp_cd', $employeeCode)->get();
            DB::commit();
            return $employees;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    function searchEmployee(): Collection
    {
        try {
            DB::beginTransaction();
            $employees = QueryBuilder::for(Employee::class)
                ->allowedFilters(['emp_name', 'email', 'phone', 'address'])
                ->get();
            DB::commit();
            return $employees;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function create($request): bool
    {
        try {
            DB::beginTransaction();
            $employeeData = [
                'emp_cd' => $request->input('emp_cd'),
                'emp_name' => $request->input('emp_name'),
                'position' => $request->input('position'),
                'group_cd' => $request->input('group_cd'),
                'gl_flag' => $request->input('gl_flag'),
                'activation_code' => $request->input('activation_code'),
                'emp_email' => $request->input('emp_email'),
            ];
            $employees = DB::table('employeemaster')->insert($employeeData);
            DB::commit();
            return $employees;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($emp_cd, $request): bool
    {
        try {
            DB::beginTransaction();
            $employeeData = [
                'emp_cd' => $request->input('emp_cd'),
                'emp_name' => $request->input('emp_name'),
                'position' => $request->input('position'),
                'group_cd' => $request->input('group_cd'),
                'gl_flag' => $request->input('gl_flag'),
                'activation_code' => $request->input('activation_code'),
                'emp_email' => $request->input('emp_email'),
            ];
            $employees = DB::table('employeemaster')->where('emp_cd', $emp_cd)->update($employeeData);
            DB::commit();
            return $employees;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($emp_cd): bool
    {
        try {
            DB::beginTransaction();
            $employees = DB::table('employeemaster')->where('emp_cd', $emp_cd)->delete();
            DB::commit();
            return $employees;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}