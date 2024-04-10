<?php

namespace App\Http\Controllers;

use App\Events\ProjectEvent;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $projectService)
    {
    }

    public function index()
    {
        try {
            $projects = $this->projectService->getProjects();
            $projectData = $this->projectService->getCustomerData($projects);
            $result[0] = 'Selected';
            $result[1] = 'Project List Data';
            event(new ProjectEvent($result));
            return new ProjectResource($projectData);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function getByCustomId(int $custom_id)
    {
        try {
            $projectData = $this->projectService->getByCustomId($custom_id);
            $result[0] = 'Searched';
            $result[1] = 'Project Data by Customer Id';
            event(new ProjectEvent($result));
            return new ProjectResource($projectData);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function getCurrentProjects()
    {
        try {
            $projects = $this->projectService->getCurrentProjects();
            $projectData = $this->projectService->getCustomerData($projects);
            $result[0] = 'Selected';
            $result[1] = 'Current Project Data';
            event(new ProjectEvent($result));
            return new ProjectResource($projectData);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function store(ProjectRequest $request)
    {
        try {
            $data = $request->validated();
            $project = $this->projectService->store($data);
            $result[0] = 'Created';
            $result[1] = $project->project_name;
            event(new ProjectEvent($result));
            return Response::success('Success', 200, []);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function edit(int $projectId)
    {
        try {
            $projectData = $this->projectService->getById($projectId);
            $customerArr = $this->projectService->getCustomerIdByProjectId($projectId);
            $customerId = $customerArr[0]['customer_id'];
            $responseCustomer = Http::CustomerService()->get("/customers/{$customerId}");
            $customerData = $responseCustomer->json();
            $projectData[0]->project['customer'] = $customerData[0];
            return new ProjectResource($projectData);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function update(ProjectRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $project = $this->projectService->update($data, $id);
            $result[0] = 'Updated';
            $result[1] = $project->project_name;
            event(new ProjectEvent($result));
            return Response::success('Success', 200, []);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $ids = $request->input('ids');
            $ids = json_decode($ids, true);
            $project = $this->projectService->delete($ids);
            $result[0] = 'Deleted';
            $result[1] = $project->project_name;
            event(new ProjectEvent($result));
            return Response::success('Success', 200, []);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function filter()
    {
        try {
            $filterProjectData = $this->projectService->filter();
            $projectData = $this->projectService->getCustomerData($filterProjectData);
            return new ProjectResource($projectData);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function search()
    {
        try {
            $searchProjectData = $this->projectService->search();
            $projectData = $this->projectService->getCustomerData($searchProjectData);
            $result[0] = 'Searched';
            $result[1] = 'Project Data by Project Name';
            event(new ProjectEvent($result));
            return new ProjectResource($projectData);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }
}
