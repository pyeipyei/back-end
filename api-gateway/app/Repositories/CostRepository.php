<?php

namespace App\Repositories;

use App\Models\Assign;
use App\Models\Cost;
use App\Models\Order;
use App\Models\Project;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Http;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Carbon;

class CostRepository
{
    public function index(): array
    {
        DB::begintransaction();
        try {
            $costs = Cost::select('costs.*', 'projects.project_name', 'costs.project_id')
                ->join('projects', 'projects.id', '=', 'costs.project_id')
                ->orderBy('projects.project_name', 'asc')
                ->get();
            $data = [
                "costs" => $costs,
            ];

            DB::commit();

            return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function getAllEmployee(): object|array
    {
        try {
            $limiter = app(RateLimiter::class);
            $actionKey = 'select_all_emmployees';
            $threshold = 10; // Define the rate limit threshold
            // Check if the rate limit is exceeded
            if ($limiter->tooManyAttempts($actionKey, $threshold)) {
                // Exceeded the maximum number of failed attempts.
                return $this->failOrFallback();
            }
            // Perform an HTTP GET request with the configured base URL
            $response = Http::EmployeeService()->get('/employees');
            return $response->json()['data'];
        } catch (Exception $e) {
            $limiter->hit($actionKey, Carbon::now()->addMinutes(15));
            return $this->failOrFallback();
        }
    }



    public function detailAssigned(int $project_id)
    {
        DB::beginTransaction();
        try {
            $manHour = [];
            $unitPrice = [];
            $location = [];

            $assignData = Assign::all();
            $employeeData = $this->getAllEmployee();
            $employeeLocations = [];

            foreach ($employeeData as $employee) {
                $employeeLocations[$employee['emp_cd']] = $employee['location'];
            }
            $months = ["january" => 1, "february" => 1, "march" => 1, "april" => 1, "may" => 1, "june" => 1, "july" => 1, "august" => 1, "september" => 1, "october" => 1, "november" => 1, "december" => 1];
            foreach ($assignData as $month => $json) {
                $data = json_decode($json, true);
                foreach ($data as $key => $value) {
                    if (isset($months[$key])) {
                        $infoArray = json_decode($value, true);

                        if (!empty($infoArray)) {
                            foreach ($infoArray as $info) {
                                $role = $info['role'];
                                $projectId = $info['project_id'];
                                $memberType = $info['member_type'];
                                $employeeCode = $data['employee_code'];

                                if (isset($role, $projectId, $memberType) && $projectId == $project_id && in_array($memberType, [1, 2, 3])) {
                                    $month = $key;
                                    $key = $role . ',' . $month . ',' . $memberType . ',' . $employeeCode;

                                    $manHour[$key] = isset($manHour[$key]) ? $manHour[$key] + $info["man_month"] : $info["man_month"];
                                    $unitPrice[$role] = $unitPrice[$role] ?? $info["unit_price"];
                                    $location[$employeeCode] = $location[$employeeCode] ?? $employeeLocations[$employeeCode];
                                }
                            }
                        }
                    }
                }
            }

            $datas = [];

            foreach ($manHour as $key => $man_month) {
                list($role, $month, $memberType, $employeeCode) = explode(',', $key);

                $datas[] = [

                    "memberType" => $memberType,

                    "role" => $role,

                    "employeeCode" => $employeeCode,

                    "month" => $month,

                    "man_month" => $man_month,

                    "unitPrice" => $unitPrice,

                    "location" => $location,
                ];
            }

            $myanmarData = [];
            $japanData = [];

            foreach ($datas as $data) {
                $employeeCode = $data['employeeCode'];
                $location = $data['location'][$employeeCode] ?? null;

                if ($location === 'Myanmar') {
                    $myanmarData[] = $data;
                } elseif ($location === 'Japan') {
                    $japanData[] = $data;
                }
            }

            DB::commit();
            return ['Myanmar' => $myanmarData, 'Japan' => $japanData];
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function detailProject(int $project_id)
    {
        DB::beginTransaction();
        try {
            $data = [];

            $orders = Order::where('project_id', $project_id)->get();
            $projects = Project::where('id', $project_id)->get();
            $start = Project::where('id', $project_id)->pluck('start_date')->get(0);
            $startDate = (new DateTime($start))->modify('first day of this month');
            $end = Project::where('id', $project_id)->pluck('end_date')->get(0);
            $endDate = (new DateTime($end))->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $period = new DatePeriod($startDate, $interval, $endDate);
            $months = [];
            foreach ($period as $dt) {
                $months[] = $dt->format("F");
            }
            $projects[0]['months'] = $months;
            $orders->merge($projects);
            $data = [
                "orders" => $orders,
                "projects" => $projects,
            ];
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function search(): Collection
    {
        DB::beginTransaction();
        try {
            $costData = QueryBuilder::for(Project::class)
                ->allowedFilters(['project_name'])
                ->join('costs', 'projects.id', '=', 'costs.project_id')
                ->select('projects.*', 'projects.project_name')
                ->get();

            DB::commit();

            return $costData;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function getCustomerService(): object|array
    {
        $limiter = app(RateLimiter::class);
        $actionKey = 'get_all_customers';
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
    private function failOrFallback()
    {
        return response()->json(['error' => 'Cannot call customers API.'], 500);
    }

    public function costSummarySearch(int $year): array
    {
        return $this->calculateCostSummary($year);
    }

    public function costSummary(): array
    {
        $year = Carbon::now()->year;
        return $this->calculateCostSummary($year);
    }

    public function calculateCostSummary(int $year): array
    {
        DB::beginTransaction();
        try {
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
            $customerData = $this->getCustomerService();
            $customer = collect($customerData["data"]);
            $employee = collect($this->getAllEmployee());
            $assigns = Assign::where('year', '=', $year)->get();
            $projects = collect(Project::with('department', 'orders')->get());
            $costs = collect(Cost::all());
            $income = [];
            $cost_jp = [];
            $cost_my = [];
            $profit = [];
            $orders = collect(Order::with('project', 'project.department', 'projectType')->get());
            foreach ($projects as $project) {
                $project_type = $orders->where('project_id', $project['id'])->pluck('project_type_id')->first();
                if ($project_type > 1) {
                    $customer_name = $customer->where('id', $project['customer_id'])->pluck('customer_name')->first();
                    $income_temp = [];
                    $cost_jp_temp = [];
                    $cost_my_temp = [];
                    $payment_date = "";
                    $income_temp['project_name'] = $project['project_name'];
                    $income_temp['customer_name'] = $customer_name;
                    $income_temp['department'] = $project['department']->department_name;
                    $cost_jp_temp['project_name'] = $project['project_name'];
                    $cost_my_temp['project_name'] = $project['project_name'];
                    $cost_jp_temp['customer_name'] = $customer_name;
                    $cost_my_temp['customer_name'] = $customer_name;
                    $cost_jp_temp['department'] = $project['department']->department_name;
                    $cost_my_temp['department'] = $project['department']->department_name;
                    $jp_project_leader = $project->orders[0]->jp_project_leader;
                    $mm_project_leader = $project->orders[0]->mm_project_leader;
                    if ((!empty($jp_project_leader) && ($jp_project_leader != null)) && (!empty($mm_project_leader) && ($mm_project_leader != null))) {
                        $payment_date = $orders->where('project_id', $project['id'])->pluck('jp_payment_date')->first();
                        $jp_project_leader = $employee->where('emp_cd', $jp_project_leader)->pluck('emp_name')->first();
                        $mm_project_leader = $employee->where('emp_cd', $mm_project_leader)->pluck('emp_name')->first();
                        $income_temp['pm_pl'] = $jp_project_leader . ", " . $mm_project_leader;
                        $cost_jp_temp['pm_pl'] = $jp_project_leader;
                        $cost_my_temp['pm_pl'] = $mm_project_leader;
                    } else if (!empty($jp_project_leader) && ($jp_project_leader != null)) {
                        $payment_date = $orders->where('project_id', $project['id'])->pluck('jp_payment_date')->first();
                        $jp_project_leader = $employee->where('emp_cd', $jp_project_leader)->pluck('emp_name')->first();
                        $income_temp['pm_pl'] = $jp_project_leader;
                        $cost_jp_temp['pm_pl'] = $jp_project_leader;
                    } else {
                        $payment_date = $orders->where('project_id', $project['id'])->pluck('mm_payment_date')->first();
                        $mm_project_leader = $employee->where('emp_cd', $mm_project_leader)->pluck('emp_name')->first();
                        $income_temp['pm_pl'] = $mm_project_leader;
                        $cost_my_temp['pm_pl'] = $mm_project_leader;
                    }
                    $income_temp['marketing'] = $project['marketing_name'];
                    $cost_jp_temp['marketing'] = $project['marketing_name'];
                    $cost_my_temp['marketing'] = $project['marketing_name'];
                    $payment_date = Carbon::parse($payment_date);
                    $pay_year = $payment_date->year;
                    $pay_month = 20;
                    $profit_temp = $income_temp;
                    if ($pay_year == $year) {
                        $pay_month = ($payment_date->month - 1);
                    }
                    foreach ($months as $key => $month) {
                        $month_data = $this->costMonth($assigns, $employee, $month, $project_type, $project['id']);
                        $cost_jp_temp[$month] = $month_data[0];
                        $cost_my_temp[$month] = $month_data[1];
                        $income_cost = 0;
                        if ($key == $pay_month) {
                            $income_cost = $costs->where('project_id', $project['id'])->pluck('estimate_cost')->first();
                            $income_temp[$month] = $income_cost;
                        } else {
                            $income_temp[$month] = 0;
                        }
                        $profit_temp[$month] = $income_cost - ($month_data[0]['cost'] + $month_data[1]['cost']);
                    }
                    array_push($income, $income_temp);
                    if (count($cost_jp_temp) > 0) {
                        array_push($cost_jp, $cost_jp_temp);
                    }
                    if (count($cost_my_temp) > 0) {
                        array_push($cost_my, $cost_my_temp);
                    }
                    array_push($profit, $profit_temp);
                }
            }
            $data['income'] = $income;
            $data['jp'] = $cost_jp;
            $data['mm'] = $cost_my;
            $data['profit'] = $profit;
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function costMonth(object $assigns, object $employee, string $month, int $project_type, int $project_id): array
    {
        $man_month_jp = 0;
        $price_jp = 0;
        $man_month_mm = 0;
        $price_mm = 0;
        foreach ($assigns as $assign) {
            $monthData = json_decode($assign[$month], true);
            if (count($monthData) > 0) {
                foreach ($monthData as $monData) {
                    if ($monData['project_id'] == $project_id && $monData['project_type'] == $project_type) {
                        $location = $employee->where('emp_cd', $assign['employee_code'])->pluck('location')->first();
                        if ($location == 'Japan') {
                            $man_month_jp += $monData['man_month'];
                            $price_jp += ($monData['man_month'] * $monData['unit_price']);
                        } else {
                            $man_month_mm += $monData['man_month'];
                            $price_mm += ($monData['man_month'] * $monData['unit_price']);
                        }
                    }
                }
            }
        }
        $month_jp['man_month'] = $man_month_jp;
        $month_jp['cost'] = $price_jp;
        $cost[] = $month_jp;
        $month_mm['man_month'] = $man_month_mm;
        $month_mm['cost'] = $price_mm;
        $cost[] = $month_mm;
        return $cost;
    }
}