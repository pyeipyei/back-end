<?php

namespace App\Repositories;

use App\Models\Assign;
use App\Models\Order;
use App\Models\Project;
use App\Services\EngineerAssignService;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectRepository
{
    public function __construct(protected EngineerAssignService $engineerAssignService)
    {
    }

    public function getProjects(): Collection
    {
        DB::beginTransaction();
        try {
            $projectList = Project::with(['department', 'orders.projectType'])
                ->select('projects.*')
                ->orderBy('projects.start_date', 'desc')
                ->orderBy('projects.created_at', 'desc')
                ->get();

            DB::commit();

            return $projectList;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getByCustomId(int $custom_id)
    {
        DB::beginTransaction();
        try {
            $projectList = Project::where('customer_id', $custom_id)->get();
            DB::commit();
            return $projectList;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getCurrentProjects(): Collection
    {
        DB::beginTransaction();
        try {
            $currentDate = now();

            $projectList = Project::with(['department', 'orders.projectType'])
                ->whereDate('start_date', '<=', $currentDate)
                ->whereDate('end_date', '>=', $currentDate)
                ->get();

            DB::commit();

            return $projectList;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function store(array $data): Project
    {
        DB::beginTransaction();
        try {
            $project = Project::create($data);
            $project->orders()->create($data);
            $project->cost()->create($data);
            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getById(int $projectId): Collection
    {
        DB::beginTransaction();
        try {
            $projectData = DB::transaction(
                fn() =>
                Order::with('project', 'project.department', 'projectType')
                    ->where('project_id', $projectId)
                    ->get()
            );

            DB::commit();

            return $projectData;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(array $data, int $id): Project
    {
        DB::beginTransaction();
        try {
            $project = Project::find($id);
            $project->update($data);
            $orders = $project->orders;

            foreach ($orders as $order) {
                $order->update($data);
            }
            $cost = $project->cost;
            $cost->update($data);

            DB::commit();
            return Project::find($id);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getAssignData(): Collection
    {
        DB::beginTransaction();
        try {
            $assignData = Assign::all();

            DB::commit();

            return $assignData;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(array $ids): Project
    {
        DB::beginTransaction();
        try {
            $assignData = $this->getAssignData();
            $monthValue = [];
            foreach ($assignData as $assign) {
                $monthValue[] = $assign["january"];
                $monthValue[] = $assign["february"];
                $monthValue[] = $assign["march"];
                $monthValue[] = $assign["april"];
                $monthValue[] = $assign["may"];
                $monthValue[] = $assign["june"];
                $monthValue[] = $assign["july"];
                $monthValue[] = $assign["august"];
                $monthValue[] = $assign["september"];
                $monthValue[] = $assign["october"];
                $monthValue[] = $assign["november"];
                $monthValue[] = $assign["december"];
            }

            $projectIdsInMonthData = collect($monthValue)
            ->map(function ($assignJson) {
                return json_decode($assignJson, true);
            })
            ->collapse()
            ->pluck('project_id')
            ->filter(function ($value) {
                return is_string($value) || is_int($value);
            })
            ->flip();
            $projectName = $result = '';
            foreach ($ids as $id) {
                $project = Project::find($id);
                $result = $project;
                $projectName .= ", " . $project->project_name;
                $orders = $project->orders;
                $cost = $project->cost;

                $month = $projectIdsInMonthData->has($id);

                if ($month) {
                    if ($orders) {
                        $orders->each->delete();
                    }
                    if ($cost) {
                        $cost->delete();
                    }
                    $project->delete();
                } else {
                    if ($orders) {
                        $orders->each->forceDelete();
                    }
                    if ($cost) {
                        $cost->forceDelete();
                    }
                    $project->forceDelete();
                }
            }

            $projectName = ltrim($projectName, ', ');
            $result['project_name'] = $projectName;
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function filter(): Collection
    {
        DB::beginTransaction();
        try {
            $filterProjectData = QueryBuilder::for(Project::class)
                ->allowedFilters(['contract_status', 'payment_status', 'customer_id', 'departments.department_name'])
                ->join('departments', 'projects.department_id', '=', 'departments.id')
                ->select('projects.*', 'departments.department_name')
                ->get();

            DB::commit();

            return $filterProjectData;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function search(): Collection
    {
        DB::beginTransaction();
        try {
            $searchProjectData = QueryBuilder::for(Project::class)
                ->with(['department'])
                ->allowedFilters([AllowedFilter::exact('project_name')])
                ->get();

            DB::commit();

            return $searchProjectData;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getCustomerData(object $projectData): Collection
    {
        $limiter = app(RateLimiter::class);
        $actionKey = 'customer_service';
        $threshold = 10;

        DB::beginTransaction();

        try {
            foreach ($projectData as $project) {
                $customerArr = $this->getCustomerIdByProjectId($project['id']);
                $customerId = $customerArr[0]['customer_id'];

                try {
                    if ($limiter->tooManyAttempts($actionKey, $threshold)) {
                        return $this->failOrFallback();
                    }

                    $responseCustomer = Http::CustomerService()->get("/customers/{$customerId}");
                    $customerData = $responseCustomer->json();

                    $project['customer'] = $customerData[count($customerData) - 1];
                } catch (\Exception $e) {
                    $limiter->hit($actionKey, Carbon::now()->addMinutes(15));

                    return $this->failOrFallback();
                }
            }

            DB::commit();

            return $projectData;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getCustomerIdByProjectId(int $projectId)
    {
        DB::beginTransaction();
        try {
            $customerId = DB::transaction(fn() => Project::select('customer_id')->where('id', $projectId)->get());
            DB::commit();

            return $customerId;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function failOrFallback(): Collection
    {
        return new Collection([]);
    }
}