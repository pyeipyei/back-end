<?php

namespace App\Repositories;

use Exception;
use App\Models\Assign;
use App\Models\MemberType;
use App\Models\Project;
use App\Models\Role;
use App\Models\Cost;
use App\Models\ProjectType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Cache\RateLimiter;

class ProjectAssignRepository
{
    public function getAllProjectAssignData(): Collection
    {
        $year = Carbon::now()->year;
        return $this->getProjectData($year);
    }

    public function getDataByYear(int $year): Collection
    {
        return $this->getProjectData($year);
    }

    public function getProjectData(int $year): Collection
    {
        DB::beginTransaction();
        try {
            $response = $this->getAllEmployee();
            $projectAssign = Assign::get();
            foreach ($projectAssign as $assign) {
                $isIdExists = collect($response["data"])->contains(function ($item) use ($assign) {
                    return $item['emp_cd'] === $assign["employee_code"];
                });
                // employee id in assigns table that is not exit, assign data is deleted
                if (!$isIdExists) {
                    Assign::where('id', $assign["id"])->delete();
                }
            }
            $projectAssignData = Assign::where("year", $year)->get();
            $assignList[0] = $year;
            // change into complete assign array
            $assignList = $this->settingSelectAssignList($assignList, $projectAssignData, $response);
            DB::commit();
            return collect($assignList);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // create fake assign for no assign employees from employees service
    private function createFakeAssign(int $year, string $emp_cd, string $emp_name, string $location): array
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
        $maxAssignId = Assign::max('id');
        $maxAssignId = $maxAssignId + 1;
        $convertData["id"] = $maxAssignId;
        foreach ($months as $month) {
            $convertData[$month] = [];
        }
        $convertData["marketing_status"] = "available";
        $convertData["proposal_status"] = null;
        $convertData["careersheet_status"] = 0;
        $convertData["careersheet_link"] = null;
        $convertData["man_month"] = null;
        $convertData["unit_price"] = null;
        $convertData["year"] = $year;
        $convertData["user_id"] = null;
        $convertData["created_at"] = null;
        $convertData["updated_at"] = null;
        // group by employee data
        $employeeData["employee_code"] = $emp_cd;
        $employeeData["employee_name"] = $emp_name;
        $employeeData["location"] = $location;
        $convertData["employeeGroup"] = $employeeData;
        // group by current assign
        $currentAssign["current_status"] = "unassigned";
        $currentAssign["current_project"] = null;
        $currentAssign["current_projectType"] = null;
        $currentAssign["department"] = null;
        $convertData["currentAssign"] = $currentAssign;
        $convertData["update_flag"] = false;
        return $convertData;
    }

    private function getAllEmployee(): object|array
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

    private function getAllCustomer(): object|array
    {
        $limiter = app(RateLimiter::class);
        $actionKey = 'get_all_employees';
        $threshold = 10;
        try {
            if ($limiter->tooManyAttempts($actionKey, $threshold)) {
                return $this->failOrFallback();
            }
            return Http::CustomerService()->get('/customers');
        } catch (\Exception $exception) {
            $limiter->hit($actionKey, Carbon::now()->addMinutes(15));
            return $this->failOrFallback();
        }
    }

    private function failOrFallback(): object|array
    {
        return [];
    }

    public function getRoleAndProjectName(array $assignData): array
    {
        $projectList = Project::with(['department'])
            ->withTrashed()
            ->select('projects.*')
            ->get();
        $roleCollection = collect(Role::all());
        $projectType = collect(ProjectType::all());
        $memberType = collect(MemberType::all());
        $projectCollection = collect($projectList);
        $customer = $this->getAllCustomer();
        $customer = collect($customer['data']);
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
        $carbonStartDate = Carbon::parse(now());
        $currentMonth = strtolower($carbonStartDate->format('F'));
        $currentAssignGroup["current_status"] = "Unassign";
        $currentAssignGroup["current_project"] = null;
        $currentAssignGroup["current_projectType"] = null;
        $currentAssignGroup["current_man_month"] = null;
        foreach ($months as $month) {
            if ($assignData[$month] != null && json_decode($assignData[$month]) != null && $currentMonth == $month) {
                $monthData = json_decode($assignData[$month], true);
                $assignData[$month] = [];
                $currentAssignGroup["current_status"] = "Assigned";
                $currentAssignGroup["current_project"] = "";
                $currentAssignGroup["current_projectType"] = "";
                $currentAssignGroup["current_man_month"] = "";
                foreach ($monthData as $monData) {
                    $currentAssignGroup["current_project"] .= ", " . $projectCollection->where('id', $monData['project_id'])->pluck('project_name')->first();
                    $currentAssignGroup["current_projectType"] .= ", " . $projectType->where('id', $monData['project_type'])->pluck('project_type')->first();
                    $currentAssignGroup["current_man_month"] .= ", " . $monData['man_month'];
                    $arrData = [
                        "project_type_id" => $monData['project_type'],
                        "project_type" => $projectType->where('id', $monData['project_type'])->pluck('project_type')->first(),
                        "customer_id" => $monData['customer_id'],
                        "customer_name" => $customer->where('customer_cd', $monData['customer_id'])->pluck('customer_name')->first(),
                        "project_id" => $monData['project_id'],
                        "project_name" => $projectCollection->where('id', $monData['project_id'])->pluck('project_name')->first(),
                        "role_id" => $monData['role'],
                        "role" => $roleCollection->where('id', $monData['role'])->pluck('role_name')->first(),
                        "man_month" => $monData['man_month'],
                        "unit_price" => $monData['unit_price'],
                        "member_type_id" => $monData['member_type'],
                        "member_type" => $memberType->where('member_type_id', $monData['member_type'])->pluck('member_type')->first(),
                    ];
                    array_push($assignData[$month], $arrData);
                }
                $currentAssignGroup["current_projectType"] = ltrim($currentAssignGroup["current_projectType"], ', ');
                $currentAssignGroup["current_project"] = ltrim($currentAssignGroup["current_project"], ', ');
                $currentAssignGroup["current_man_month"] = ltrim($currentAssignGroup["current_man_month"], ', ');
            } else if ($assignData[$month] != null && json_decode($assignData[$month]) != null) {
                $monthData = json_decode($assignData[$month], true);
                $assignData[$month] = [];
                foreach ($monthData as $monData) {
                    $arrData = [
                        "project_type_id" => $monData['project_type'],
                        "project_type" => $projectType->where('id', $monData['project_type'])->pluck('project_type')->first(),
                        "customer_id" => $monData['customer_id'],
                        "customer_name" => $customer->where('customer_cd', $monData['customer_id'])->pluck('customer_name')->first(),
                        "project_id" => $monData['project_id'],
                        "project_name" => $projectCollection->where('id', $monData['project_id'])->pluck('project_name')->first(),
                        "role_id" => $monData['role'],
                        "role" => $roleCollection->where('id', $monData['role'])->pluck('role_name')->first(),
                        "man_month" => $monData['man_month'],
                        "unit_price" => $monData['unit_price'],
                        "member_type_id" => $monData['member_type'],
                        "member_type" => $memberType->where('member_type_id', $monData['member_type'])->pluck('member_type')->first(),
                    ];
                    array_push($assignData[$month], $arrData);
                }
            } else {
                $assignData[$month] = [];
            }
        }
        $assignData["currentAssign"] = $currentAssignGroup;
        // set update flag for update data
        $assignData["update_flag"] = true;
        return $assignData;
    }

    public function search(array $employeeName): Collection
    {
        DB::beginTransaction();
        try {
            $response = $this->searchEmployee($employeeName);
            $year = Carbon::now()->year;
            $responseData = $response->json();
            $employee_code = $responseData['data'][0]["emp_cd"];
            $projectAssignData = QueryBuilder::for(Assign::class)
                ->where('employee_code', $employee_code)
                ->get();
            DB::commit();
            $assignList[0] = $year;
            $assignList = $this->settingSelectAssignList($assignList, $projectAssignData, $response);
            return collect($assignList);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function searchEmployee(array $employeeName): object|array
    {
        $limiter = app(RateLimiter::class);
        $actionKey = 'search_employees';
        $threshold = 10;
        try {
            if ($limiter->tooManyAttempts($actionKey, $threshold)) {
                return $this->failOrFallback();
            }
            return Http::EmployeeService()->get('/employees/search', ['filter' => $employeeName]);
        } catch (\Exception $exception) {
            $limiter->hit($actionKey, Carbon::now()->addMinutes(15));
            return $this->failOrFallback();
        }
    }

    public function settingSelectAssignList(array $assignList, object $projectAssignData, object $response): array
    {
        $year = $assignList[0];
        $assignList = [];
        $employeeLists = collect($response["data"]);
        $uniqueAssignEngineerIds = [];
        if (count($projectAssignData->toArray()) > 0) {
            // get only employeeIds from assignData array
            $allAssignEngineerIds = array_column($projectAssignData->toArray(), 'employee_code');
            // set unique value array from array that have same employee id value
            $uniqueAssignEngineerIds = array_unique($allAssignEngineerIds);
        }
        $projectAssignData = collect($projectAssignData);
        foreach ($employeeLists as $employeeList) {
            if (in_array($employeeList['emp_cd'], $uniqueAssignEngineerIds)) {
                $assignData = $projectAssignData->where('employee_code', $employeeList['emp_cd'])->first();
                $assignData = $assignData->toArray();
                // group by employee data
                $employeeGroup["employee_code"] = $employeeList["emp_cd"];
                $employeeGroup["employee_name"] = $employeeList["emp_name"];
                $employeeGroup["location"] = $employeeList["location"];
                $assignData["employeeGroup"] = $employeeGroup;
                array_push($assignList, $this->getRoleAndProjectName($assignData));
            } else {
                array_push($assignList, $this->createFakeAssign($year, $employeeList['emp_cd'], $employeeList["emp_name"], $employeeList["location"]));
            }
        }
        return $assignList;
    }

    public function saveProjectAssign(array $data): Assign
    {
        DB::beginTransaction();
        try {
            $projectAssignData = Assign::where('employee_code', $data["employee_code"])
                ->where('year', $data["year"])
                ->where('january', json_encode($data['january']))
                ->where('february', json_encode($data['february']))
                ->where('march', json_encode($data['march']))
                ->where('april', json_encode($data['april']))
                ->where('may', json_encode($data['may']))
                ->where('june', json_encode($data['june']))
                ->where('july', json_encode($data['july']))
                ->where('august', json_encode($data['august']))
                ->where('september', json_encode($data['september']))
                ->where('october', json_encode($data['october']))
                ->where('november', json_encode($data['november']))
                ->where('december', json_encode($data['december']))
                ->where('marketing_status', $data["marketing_status"])
                ->where('proposal_status', $data["proposal_status"])
                ->where('careersheet_status', $data["careersheet_status"])
                ->where('careersheet_link', $data["careersheet_link"])
                ->get();
            if (!empty($projectAssignData->toArray()) && $data["update_flag"] == true) {
                $projectAssignData['message'] = "Your Assign Data is already Exit";
                $assign['action'] = "Updated";
                return $projectAssignData;
            } else {
                $createData = [
                    "employee_code" => $data["employee_code"],
                    "marketing_status" => $data["marketing_status"],
                    "proposal_status" => $data["proposal_status"],
                    "careersheet_status" => $data["careersheet_status"],
                    "careersheet_link" => $data["careersheet_link"],
                    "man_month" => 0,
                    "unit_price" => 0,
                    "year" => $data["year"],
                    "user_id" => $data["user_id"]
                ];
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
                // change to json format to update january to december data
                foreach ($months as $month) {
                    $createData[$month] = json_encode($data[$month]);
                    foreach ($data[$month] as $upData) {
                        $cost = Cost::where('project_id', '=', $upData['project_id'])->pluck('actual_cost')->first();
                        $actual_cost = $cost + ($upData['man_month'] * $upData['unit_price']);
                        Cost::where('project_id', '=', $upData['project_id'])->update(['actual_cost' => $actual_cost]);
                    }
                }
                $assign = Assign::insert($createData);
                $response = $this->getAllEmployee();
                $collection = collect($response["data"]);
                $assign['emp_name'] = $collection->where('emp_cd', $createData["employee_code"])->pluck('emp_name')->first();
                $assign['action'] = 'Created';
                $assign['message'] = 'Success';
                DB::commit();
                return $assign;
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function saveProjectData(array $data): Assign
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
        $createAssign = [
            "employee_code" => $data["employee_code"],
            "marketing_status" => $data["marketing_status"],
            "proposal_status" => $data["proposal_status"],
            "careersheet_status" => $data["careersheet_status"],
            "careersheet_link" => $data["careersheet_link"],
            "year" => $data["year"],
            "user_id" => $data["user_id"]
        ];
        foreach ($months as $month) {
            $createAssign[$month] = json_encode($data[$month]);
            foreach ($data[$month] as $upData) {
                $cost = Cost::where('project_id', '=', $upData['project_id'])->pluck('actual_cost')->first();
                $actual_cost = $cost + ($upData['man_month'] * $upData['unit_price']);
                Cost::where('project_id', '=', $upData['project_id'])->update(['actual_cost' => $actual_cost]);
            }
        }
        $assign = new Assign($createAssign);
        $assign->save();
        $response = $this->getAllEmployee();
        $collection = collect($response["data"]);
        $assign['emp_name'] = $collection->where('emp_cd', $createAssign["employee_code"])->pluck('emp_name')->first();
        $assign['action'] = 'Created';
        $assign['message'] = 'Success';
        DB::commit();
        return $assign;
    }

    public function updateProjectAssign(int $assign_id, array $data): Assign
    {
        DB::beginTransaction();
        $response = $this->getAllEmployee();
        $collection = collect($response["data"]);
        $emp_name = $collection->where('emp_cd', $data["employee_code"])->pluck('emp_name')->first();
        try {
            $projectAssignData = Assign::
                where('employee_code', $data["employee_code"])
                ->where('year', $data["year"])
                ->where('january', json_encode($data['january']))
                ->where('february', json_encode($data['february']))
                ->where('march', json_encode($data['march']))
                ->where('april', json_encode($data['april']))
                ->where('may', json_encode($data['may']))
                ->where('june', json_encode($data['june']))
                ->where('july', json_encode($data['july']))
                ->where('august', json_encode($data['august']))
                ->where('september', json_encode($data['september']))
                ->where('october', json_encode($data['october']))
                ->where('november', json_encode($data['november']))
                ->where('december', json_encode($data['december']))
                ->where('marketing_status', $data["marketing_status"])
                ->where('proposal_status', $data["proposal_status"])
                ->where('careersheet_status', $data["careersheet_status"])
                ->where('careersheet_link', $data["careersheet_link"])
                ->get();
            if (!empty($projectAssignData->toArray())) {
                $projectAssignData['message'] = "Your Assign Data is already Exit";
                $assign['emp_name'] = $emp_name;
                $assign['action'] = "Updated";
                return $projectAssignData;
            } else {
                // insert unassigned engineer data from employee table
                if ($data['update_flag'] == false) {
                    if (isset($data['update_flag'])) {
                        unset($data['update_flag']);
                    }
                    return $this->saveProjectData($data);
                } else {
                    // update assigned engineer data from assign table
                    if (isset($data['update_flag'])) {
                        unset($data['update_flag']);
                    }
                    $updateData = [
                        "marketing_status" => $data["marketing_status"],
                        "proposal_status" => $data["proposal_status"],
                        "careersheet_status" => $data["careersheet_status"],
                        "careersheet_link" => $data["careersheet_link"],
                        "user_id" => $data["user_id"]
                    ];
                    $tblData = collect(Assign::where("id", $assign_id)->get());
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
                    foreach ($months as $month) {
                        $updateData[$month] = json_encode($data[$month]);
                        $tbData = json_decode($tblData[0]->$month);
                        if (count($tbData) > 0) {
                            foreach ($tbData as $tData) {
                                $cost = Cost::where('project_id', '=', $tData->project_id)->pluck('actual_cost')->first();
                                $actual_cost = $cost - ($tData->man_month * $tData->unit_price);
                                Cost::where('project_id', '=', $tData->project_id)->update(['actual_cost' => $actual_cost]);
                            }
                        }
                        if (count($data[$month]) > 0) {
                            foreach ($data[$month] as $upData) {
                                $cost = Cost::where('project_id', '=', $upData['project_id'])->pluck('actual_cost')->first();
                                $actual_cost = $cost + ($upData['man_month'] * $upData['unit_price']);
                                Cost::where('project_id', '=', $upData['project_id'])->update(['actual_cost' => $actual_cost]);
                            }
                        }
                    }
                    Assign::where('id', $assign_id)->update($updateData);
                    $assign = Assign::find($assign_id);
                    $assign['emp_name'] = $emp_name;
                    $assign['action'] = "Updated";
                    $assign['message'] = "Success";
                    DB::commit();
                    return $assign;
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getAssignById(int $assignId, int $year, string $emp_cd): object|array
    {
        DB::beginTransaction();
        try {
            $response = $this->getAllEmployee();
            $hasAssignData = Assign::where('id', '=', $assignId)
                ->where('employee_code', '=', $emp_cd)
                ->where('year', '=', $year)
                ->get();
            if (!empty($hasAssignData->toArray())) {
                // // for already assign data
                $assignData = $hasAssignData->toArray()[0];
                $assignList = [];
                $collection = collect($response["data"]);
                array_push($assignList, $this->getRoleAndProjectName($assignData));
                $employeeGroup["employee_code"] = $assignData["employee_code"];
                $employeeGroup["employee_name"] = $collection->where('emp_cd', $assignData["employee_code"])->pluck('emp_name')->first();
                $assignList[0]["employeeGroup"] = $employeeGroup;
                DB::commit();
                return $assignList;
            } else {
                // for fake assign data
                $convertToAssignData = $this->createFakeOne($year, $emp_cd);
                DB::commit();
                return $convertToAssignData;
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function createFakeOne(int $year, string $emp_cd): object|array
    {
        $response = $this->getAllEmployee();
        $assigns = array_filter($response["data"], function ($engineer) use ($emp_cd) {
            return $engineer['emp_cd'] === $emp_cd;
        });
        $responseAssignData = [];
        foreach ($assigns as $assign) {
            $responseAssignData = [$assign];
        }
        $convertToAssignData = [];
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
        // get max id from assign table for set fake assign_id from unassigned employee data
        $maxAssignId = Assign::max('id');
        // convert as assign array type from employeeData array
        $maxAssignId = $maxAssignId + 1;
        $convertData["id"] = $maxAssignId;
        foreach ($months as $month) {
            $monData = [
                "project_type" => null,
                "customer_id" => null,
                "project_id" => null,
                "role" => null,
                "man_month" => null,
                "unit_price" => null,
                "member_type" => null,
            ];
            $convertData[$month] = [$monData];
        }
        $convertData["marketing_status"] = "available";
        $convertData["proposal_status"] = null;
        $convertData["careersheet_status"] = 0;
        $convertData["careersheet_link"] = null;
        $convertData["man_month"] = null;
        $convertData["unit_price"] = null;
        $convertData["year"] = $year;
        $convertData["user_id"] = null;
        $convertData["created_at"] = null;
        $convertData["updated_at"] = null;
        // group by employee data
        $employeeData["employee_code"] = $responseAssignData[0]["emp_cd"];
        $employeeData["employee_name"] = $responseAssignData[0]["emp_name"];
        $employeeData["location"] = $responseAssignData[0]["location"];
        $convertData["employeeGroup"] = $employeeData;
        // group by current assign
        $currentAssign["current_status"] = "unassigned";
        $currentAssign["current_project"] = null;
        $currentAssign["current_projectType"] = null;
        $currentAssign["department"] = null;
        $convertData["currentAssign"] = $currentAssign;
        $convertData["update_flag"] = false;
        array_push($convertToAssignData, $convertData);
        return $convertToAssignData;
    }
}