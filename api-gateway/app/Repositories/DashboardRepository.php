<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Project;
use App\Models\Assign;
use App\Models\ProjectType;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Department;
use Illuminate\Support\Carbon;

class DashboardRepository
{
    public function __construct(protected Project $project, protected Assign $assign, protected Order $order)
    {
    }

    public function getDashboardData(): array
    {
        try {
            DB::beginTransaction();
            $totoalProjects = Project::count();
            $currentProjects = collect(Project::where('end_date', '>=', Carbon::today())->where('start_date', '<=', Carbon::today())->get());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        $projectCount = count($currentProjects);
        $limiter = app(RateLimiter::class);
        $actionKey = 'getAPI';
        $threshold = 10;
        try {
            if ($limiter->tooManyAttempts($actionKey, $threshold)) {
                return $this->failOrFallback();
            }
            $customers = Http::CustomerService()->timeout(4)->get('/customers');
            $employees = Http::EmployeeService()->timeout(4)->get('/employees'); // All employees (JP+MM)
        } catch (\Exception $exception) {
            $limiter->hit($actionKey, Carbon::now()->addMinutes(16));
            return $this->failOrFallback();
        }
        $cutomerObject = json_decode($customers);
        $customerCount = count($cutomerObject->data);
        $employeeObject = json_decode($employees);
        $employeeCount = count($employeeObject->data);
        $data = [
            "totalProjects" => $totoalProjects,
            "currentProjects" => $projectCount,
            "customerCount" => $customerCount,
            "employeeCount" => $employeeCount,
        ];
        return $data;
    }

    public function getEngineerStatus(int $year, int $month): array
    {
        $months = [
            'january',
            'february',
            'march',
            'april',
            'may',
            'june',
            'july',
            'august',
            'september',
            'october',
            'november',
            'december'
        ];
        $currentMonth = $months[$month - 1];
        $limiter = app(RateLimiter::class);
        $actionKey = 'getAPI';
        $threshold = 10;
        try {
            if ($limiter->tooManyAttempts($actionKey, $threshold)) {
                return $this->failOrFallback();
            }
            $employees = Http::EmployeeService()->timeout(4)->get('/employees'); // All employees (JP+MM)
        } catch (\Exception $exception) {
            $limiter->hit($actionKey, Carbon::now()->addMinutes(16));
            return $this->failOrFallback();
        }
        $employeeObject = json_decode($employees);
        $assignData = collect(Assign::where('year', '=', $year)->get());
        $project_types = collect(ProjectType::select('project_type', 'id')->get())->map(function ($types) {
            $types['count'] = 0;
            return $types;
        });
        $mem_unassign = 0;
        foreach ($employeeObject->data as $cust) {
            $emp_projects = $assignData->where("employee_code", '=', $cust->emp_cd)->first();
            if (!empty($emp_projects)) {
                $monthData = json_decode($emp_projects->$currentMonth, true);
                if (!empty($monthData)) {
                    foreach ($monthData as $monData) {
                        $project_types = $project_types->map(function ($types) use ($monData) {
                            if ($types->id == $monData['project_type']) {
                                $types->count += 1;
                            }
                            return $types;
                        });
                    }
                } else {
                    $mem_unassign += 1;
                }
            } else {
                $mem_unassign += 1;
            }
        }
        $engineer_status = [];
        foreach ($project_types as $types) {
            $engineer_status[$types->project_type] = $types->count;
        }
        $engineer_status['Unassign'] = $mem_unassign;
        return $engineer_status;
    }

    public function failOrFallback(): array
    {
        $error = [
            "error" => "Cannot call custom API"
        ];
        return $error;
    }

    public function yearlyIncome(): object
    {
        $year = Carbon::now()->year;
        return $this->calYearlyIncome($year);
    }

    public function filterYearlyIncome($year): object
    {
        return $this->calYearlyIncome($year);
    }
    public function calYearlyIncome($year)
    {
        DB::begintransaction();
        try {
            $departmentData = collect(Department::select('id', 'department_name')->get())->map(function ($department) {
                $department['cost'] = 0;
                return $department;
            });
            $projects = Project::with('Department', 'Orders')->get();
            foreach ($projects as $project) {
                if ($project->orders[0]->project_type_id != 1) {
                    if ($project->orders[0]->jp_payment_date != null) {
                        $payment_date = $project->orders[0]->jp_payment_date;
                        $payment_date = Carbon::parse($payment_date);
                        $pay_year = $payment_date->year;
                        if ($pay_year == $year) {
                            $department_id = $project->department_id;
                            $income = $project->orders[0]->jp_order_amount;
                            $departmentData = $departmentData->map(function ($department) use ($department_id, $income) {
                                if ($department->id == $department_id) {
                                    $department->cost = $department->cost + $income;
                                }
                                return $department;
                            });
                        }
                    } else if ($project->orders[0]->mm_payment_date != null) {
                        $payment_date = $project->orders[0]->mm_payment_date;
                        $payment_date = Carbon::parse($payment_date);
                        $pay_year = $payment_date->year;
                        if ($pay_year == $year) {
                            $department_id = $project->department_id;
                            $income = $project->orders[0]->mm_order_amount;
                            $departmentData = $departmentData->map(function ($department) use ($department_id, $income) {
                                if ($department->id == $department_id) {
                                    $department->cost = $department->cost + $income;
                                }
                                return $department;
                            });
                        }

                    }
                }
            }
            DB::commit();
            return $departmentData;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function monthlyIncome(int $year)
    {
        DB::begintransaction();
        try {
            $allMonth = [
                ['month' => 'january', 'id' => 1, 'income' => 0],
                ['month' => 'february', 'id' => 2, 'income' => 0],
                ['month' => 'march', 'id' => 3, 'income' => 0],
                ['month' => 'april', 'id' => 4, 'income' => 0],
                ['month' => 'may', 'id' => 5, 'income' => 0],
                ['month' => 'june', 'id' => 6, 'income' => 0],
                ['month' => 'july', 'id' => 7, 'income' => 0],
                ['month' => 'august', 'id' => 8, 'income' => 0],
                ['month' => 'september', 'id' => 9, 'income' => 0],
                ['month' => 'october', 'id' => 10, 'income' => 0],
                ['month' => 'november', 'id' => 11, 'income' => 0],
                ['month' => 'december', 'id' => 12, 'income' => 0],
            ];
            $jpMonth = $mmMonth = $allMonth;
            $projects = Project::with('Department', 'Orders')->get();
            foreach ($projects as $project) {
                if ($project->orders[0]->project_type_id != 1) {
                    if ($project->orders[0]->jp_payment_date != null) {
                        $payment_date = $project->orders[0]->jp_payment_date;
                        $payment_date = Carbon::parse($payment_date);
                        $pay_year = $payment_date->year;
                        if ($pay_year == $year) {
                            $pay_month = $payment_date->month;
                            $income = $project->orders[0]->jp_order_amount;
                            $allMonth = array_map(function ($month) use ($pay_month, $income) {
                                if ($month['id'] == $pay_month) {
                                    $month['income'] = $month['income'] + $income;
                                }
                                return $month;
                            }, $allMonth);
                            $jpMonth = array_map(function ($month) use ($pay_month, $income) {
                                if ($month['id'] == $pay_month) {
                                    $month['income'] = $month['income'] + $income;
                                }
                                return $month;
                            }, $jpMonth);
                        }
                    } else if ($project->orders[0]->mm_payment_date != null) {
                        $payment_date = $project->orders[0]->mm_payment_date;
                        $payment_date = Carbon::parse($payment_date);
                        $pay_year = $payment_date->year;
                        if ($pay_year == $year) {
                            $pay_month = $payment_date->month;
                            $income = $project->orders[0]->mm_order_amount;
                            $allMonth = array_map(function ($month) use ($pay_month, $income) {
                                if ($month['id'] == $pay_month) {
                                    $month['income'] = $month['income'] + $income;
                                }
                                return $month;
                            }, $allMonth);
                            $mmMonth = array_map(function ($month) use ($pay_month, $income) {
                                if ($month['id'] == $pay_month) {
                                    $month['income'] = $month['income'] + $income;
                                }
                                return $month;
                            }, $mmMonth);
                        }
                    }
                }
            }
            $data = [
                "all" => $allMonth,
                "jp" => $jpMonth,
                "mm" => $mmMonth,
            ];
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}