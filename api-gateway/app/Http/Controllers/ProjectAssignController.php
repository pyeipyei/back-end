<?php

namespace App\Http\Controllers;

use App\Events\AssignInfoEvent;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectAssignRequest;
use App\Services\ProjectAssignService;
use App\Http\Resources\ProjectAssignResource;
use Illuminate\Support\Facades\Response;

class ProjectAssignController extends Controller
{
    public function __construct(private ProjectAssignService $projectAssignService)
    {
    }

    public function index()
    {
        try {
            $responseData = $this->projectAssignService->getAllProjectAssignData();
            $result[0] = 'Selected';
            $result[1] = 'Assign Info List Data';
            event(new AssignInfoEvent($result));
            return new ProjectAssignResource($responseData);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function searchYear(int $year)
    {
        try {
            $responseData = $this->projectAssignService->getDataByYear($year);
            $result[0] = 'Selected';
            $result[1] = 'Assign Info List ' . $year . ' Data ';
            event(new AssignInfoEvent($result));
            return new ProjectAssignResource($responseData);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }


    public function search(Request $request)
    {
        try {
            $filter = $request->query('filter', []);
            $projectAssignData = $this->projectAssignService->search($filter);
            $result[0] = 'Selected';
            $result[1] = 'Assign Info Data by ' . key($filter);
            event(new AssignInfoEvent($result));
            return Response::success('Success', 200, ["projectAssignData" => $projectAssignData]);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function store(ProjectAssignRequest $request)
    {
        try {
            $data = $request->validated();
            $assign = $this->projectAssignService->saveProjectAssign($data);
            $result[0] = 'Created';
            $result[1] = $assign->emp_name;
            event(new AssignInfoEvent($result));
            return Response::success($assign->message, 200, []);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function edit($id, $year, $emp_cd)
    {
        try {
            $responseData = $this->projectAssignService->getAssignById($id, $year, $emp_cd);
            return Response::success('Success', 200, $responseData);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function update($id, ProjectAssignRequest $request)
    {
        try {
            $data = $request->validated();
            $assign = $this->projectAssignService->updateProjectAssign($id, $data);
            $result[0] = 'Selected';
            $result[1] = $assign->emp_name;
            event(new AssignInfoEvent($result));
            return Response::success($assign->message, 200, []);
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }

    }
}
