<?php

namespace App\Repositories;

use App\Models\Assign;
use App\Models\Order;
use App\Models\Cost;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Cache\RateLimiter;

class EngineerAssignRepository {
    public function saveEngineerAssign(array $data): array {
        DB::beginTransaction();
        try {
            $projectData = collect($data)->only(['customer_id', 'start_date', 'end_date'])->toArray();
            $project_type = Order::where('project_id', $data['project_id'])->pluck('project_type_id')->first();
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
                'december',
            ];
            // parse the date string into a Carbon instance
            $carbonStartDate = Carbon::parse($projectData['start_date']);
            $startYear = $carbonStartDate->year;
            $startMonth = $carbonStartDate->month;
            $carbonEndDate = Carbon::parse($projectData['end_date']);
            $endYear = $carbonEndDate->year;
            $endMonth = $carbonEndDate->month;
            if($startYear == $endYear) {
                // same start year and end year
                $this->storeEngineerAss($data, $startYear, $startMonth, $endMonth, $months, $project_type);
            } else {
                // not same start year and end year
                $this->storeStartYearEngineerAssign($data, $startYear, $startMonth, $months, $project_type);
                for($y = ($startYear + 1); $y <= ($endYear - 1); $y++) {
                    $this->storeNextYearEngineerAssign($data, $y, $months, $project_type);
                }
                $this->storeEndYearEngineerAssign($data, $endYear, $endMonth, $months, $project_type);
            }
            $result[0] = $projectData['start_date'];
            $result[1] = $projectData['end_date'];
            $response = $this->getAllEmployee();
            $collection = collect($response["data"]);
            $emp_name = "";
            foreach($data['projectEmployees'] as $emp) {
                foreach($emp['employeesId'] as $empId) {
                    $emp_name .= ", ".$collection->where('emp_cd', $empId)->pluck('emp_name')->first();
                }
            }
            $result[2] = ltrim($emp_name, ', ');
            $result[3] = "Created";
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function getAllEmployee(): object|array {
        $limiter = app(RateLimiter::class);
        $actionKey = 'get_all_employees';
        $threshold = 10;
        try {
            if($limiter->tooManyAttempts($actionKey, $threshold)) {
                return $this->failOrFallback();
            }
            return Http::EmployeeService()->get('/employees');
        } catch (\Exception $exception) {
            $limiter->hit($actionKey, Carbon::now()->addMinutes(15));
            return $this->failOrFallback();
        }
    }

    private function failOrFallback(): object|array {
        return [];
    }

    public function storeEngineerAss(array $data, int $year, int $startMonth, int $endMonth, array $months, int $project_type) {
        $mData = [
            "project_type" => $project_type,
            "customer_id" => $data['customer_id'],
            "project_id" => $data['project_id'],
        ];
        $total_actual_cost = 0;
        $monCount = $endMonth - $startMonth + 1;
        foreach($data['projectEmployees'] as $emp) {
            $manCount = 0;
            
            $mData['role'] = $emp['role'];
            $mData['man_month'] = $emp['man_month'];
            $mData['unit_price'] = $emp['unit_price'];
            $mData['member_type'] = $emp['member_type'];
            foreach($emp['employeesId'] as $empId) {
                $manCount += 1;
                $checkEmp = collect(Assign::where('employee_code', $empId)
                    ->where('year', $year)
                    ->get());
                if(count($checkEmp) > 0) {
                    $updateAssign = [];
                    for($i = ($startMonth - 1); $i < $endMonth; $i++) {
                        $monCount += 1;
                        $monName = $months[$i];
                        $monData = json_decode($checkEmp[0]->$monName);
                        array_push($monData, $mData);
                        $updateAssign[$monName] = json_encode($monData);
                    }
                    Assign::where('id', $checkEmp[0]->id)->update($updateAssign);
                } else {
                    $createAssign = [
                        "employee_code" => $empId,
                        "marketing_status" => "not available",
                        "proposal_status" => null,
                        "careersheet_status" => 0,
                        "careersheet_link" => null,
                        "year" => $year,
                        "user_id" => null
                    ];
                    foreach($months as $key => $month) {
                        if(($key + 1) >= $startMonth && ($key + 1) <= $endMonth) {
                            
                            $createAssign[$month] = json_encode([$mData]);
                        } else {
                            $createAssign[$month] = json_encode([]);
                        }
                    }
                    Assign::insert($createAssign);
                }
            }
            $cost = Cost::where('project_id', '=', $data['project_id'])->pluck('actual_cost')->first();
            $total_actual_cost = $cost + ($emp['man_month'] * $emp['unit_price'] * $manCount * $monCount);
        }
        Cost::where('project_id', '=', $data['project_id'])->update(['actual_cost' => $total_actual_cost]);
    }

    public function storeStartYearEngineerAssign(array $data, int $startYear, int $startMonth, array $months, int $project_type) {
        $mData = [
            "project_type" => $project_type,
            "customer_id" => $data['customer_id'],
            "project_id" => $data['project_id'],
        ];
        $existing_cost = Cost::where('project_id', '=', $data['project_id'])->pluck('actual_cost')->first();
        $monCount = 12 - $startMonth + 1;
        $total_actual_cost = $existing_cost ?? 0;
        foreach($data['projectEmployees'] as $emp) {
            $manCount = 0;
            $mData['role'] = $emp['role'];
            $mData['man_month'] = $emp['man_month'];
            $mData['unit_price'] = $emp['unit_price'];
            $mData['member_type'] = $emp['member_type'];
            foreach($emp['employeesId'] as $empId) {
                $manCount += 1;
                $checkEmp = collect(Assign::where('employee_code', $empId)
                    ->where('year', $startYear)
                    ->get());
                if(count($checkEmp) > 0) {
                    $updateAssign = [];
                    for($i = ($startMonth - 1); $i <= 11; $i++) {
                        $monName = $months[$i];
                        $monData = json_decode($checkEmp[0]->$monName);
                        array_push($monData, $mData);
                        $updateAssign[$monName] = json_encode($monData);
                    }
                    Assign::where('id', $checkEmp[0]->id)->update($updateAssign);
                } else {
                    $createAssign = [
                        "employee_code" => $empId,
                        "marketing_status" => "not available",
                        "proposal_status" => null,
                        "careersheet_status" => 0,
                        "careersheet_link" => null,
                        "year" => $startYear,
                        "user_id" => null
                    ];
                    foreach($months as $key => $month) {
                        if(($key + 1) >= $startMonth) {
                            $createAssign[$month] = json_encode([$mData]);
                        } else {
                            $createAssign[$month] = json_encode([]);
                        }
                    }
                    Assign::insert($createAssign);
                }
            }
            $cost = $emp['man_month'] * $emp['unit_price'] * $manCount * $monCount;
            $total_actual_cost += $cost;
        }
        Cost::where('project_id', '=', $data['project_id'])->update(['actual_cost' => $total_actual_cost]);
    }

    public function storeEndYearEngineerAssign(array $data, int $endYear, int $endMonth, array $months, int $project_type) {
        $mData = [
            "project_type" => $project_type,
            "customer_id" => $data['customer_id'],
            "project_id" => $data['project_id'],
        ];
        $existing_cost = Cost::where('project_id', '=', $data['project_id'])->pluck('actual_cost')->first();
        $monCount = $endMonth;
        $total_actual_cost = $existing_cost ?? 0;
        foreach($data['projectEmployees'] as $emp) {
            $manCount = 0;
            $mData['role'] = $emp['role'];
            $mData['man_month'] = $emp['man_month'];
            $mData['unit_price'] = $emp['unit_price'];
            $mData['member_type'] = $emp['member_type'];
            foreach($emp['employeesId'] as $empId) {
                $manCount += 1;
                $checkEmp = collect(Assign::where('employee_code', $empId)
                    ->where('year', $endYear)
                    ->get());
                if(count($checkEmp) > 0) {
                    $updateAssign = [];
                    for($i = 0; $i <= ($endMonth - 1); $i++) {
                        $monName = $months[$i];
                        $monData = json_decode($checkEmp[0]->$monName);
                        array_push($monData, $mData);
                        $updateAssign[$monName] = json_encode($monData);
                    }
                    Assign::where('id', $checkEmp[0]->id)->update($updateAssign);
                } else {
                    $createAssign = [
                        "employee_code" => $empId,
                        "marketing_status" => "not available",
                        "proposal_status" => null,
                        "careersheet_status" => 0,
                        "careersheet_link" => null,
                        "year" => $endYear,
                        "user_id" => null
                    ];
                    foreach($months as $key => $month) {
                        if(($key + 1) <= $endMonth) {
                            $createAssign[$month] = json_encode([$mData]);
                        } else {
                            $createAssign[$month] = json_encode([]);
                        }
                    }
                    Assign::insert($createAssign);
                }
            }
            $cost = $emp['man_month'] * $emp['unit_price'] * $manCount * $monCount;
            $total_actual_cost += $cost;
        }
        Cost::where('project_id', '=', $data['project_id'])->update(['actual_cost' => $total_actual_cost]);
    }

    public function storeNextYearEngineerAssign(array $data, int $year, array $months, int $project_type) {
        $mData = [
            "project_type" => $project_type,
            "customer_id" => $data['customer_id'],
            "project_id" => $data['project_id'],
        ];
        $existing_cost = Cost::where('project_id', '=', $data['project_id'])->pluck('actual_cost')->first();
        $monCount = 12;
        $total_actual_cost = $existing_cost ?? 0;
        foreach($data['projectEmployees'] as $emp) {
            $manCount = 0;
            $mData['role'] = $emp['role'];
            $mData['man_month'] = $emp['man_month'];
            $mData['unit_price'] = $emp['unit_price'];
            $mData['member_type'] = $emp['member_type'];
            foreach($emp['employeesId'] as $empId) {
                $manCount += 1;
                $checkEmp = collect(Assign::where('employee_code', $empId)
                    ->where('year', $year)
                    ->get());
                if(count($checkEmp) > 0) {
                    $updateAssign = [];
                    foreach($months as $month) {
                        $monData = json_decode($checkEmp[0]->$month);
                        array_push($monData, $mData);
                        $updateAssign[$month] = json_encode($monData);
                    }
                    Assign::where('id', $checkEmp[0]->id)->update($updateAssign);
                } else {
                    $createAssign = [
                        "employee_code" => $empId,
                        "marketing_status" => "not available",
                        "proposal_status" => null,
                        "careersheet_status" => 0,
                        "careersheet_link" => null,
                        "year" => $year,
                        "user_id" => null
                    ];
                    foreach($months as $month) {
                        $createAssign[$month] = json_encode([$mData]);
                    }
                    Assign::insert($createAssign);
                }
            }
            $cost = $emp['man_month'] * $emp['unit_price'] * $manCount * $monCount;
            $total_actual_cost += $cost;
        }
        Cost::where('project_id', '=', $data['project_id'])->update(['actual_cost' => $total_actual_cost]);
    }
}