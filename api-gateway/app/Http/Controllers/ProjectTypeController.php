<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectTypeRequest;
use App\Http\Resources\ProjectTypeResource;
use App\Models\ProjectType;
use App\Services\ProjectTypeService;
use Illuminate\Support\Facades\Response;

class ProjectTypeController extends Controller
{
    public function __construct(private ProjectTypeService $projectTypeService)
    {
    }

    public function index()
    {
        $projectTypes = $this->projectTypeService->getAllProjectTypes();

        return new ProjectTypeResource($projectTypes);
    }

    public function offshore()
    {
        $projectTypes = $this->projectTypeService->offshore();
        return new ProjectTypeResource($projectTypes);
    }

    public function store(ProjectTypeRequest $request)
    {
        $projectTypeData = [
            'project_type' => $request->input('project_type'),
        ];

        $this->projectTypeService->createProjectType($projectTypeData);

        return Response::success('Success', 200, []);
    }

    public function edit(ProjectType $projectType)
    {
        $projectType = $this->projectTypeService->getProjectTypeById($projectType->id);
        return new ProjectTypeResource($projectType);
    }

    public function update(ProjectTypeRequest $request, ProjectType $projectType)
    {
        $projectTypeData = [
            'project_type' => $request->input('project_type'),
        ];

        $this->projectTypeService->updateProjectType($projectType, $projectTypeData);

        return Response::success('Success', 200, []);
    }

    public function destroy(ProjectType $projectType)
    {
        $this->projectTypeService->deleteProjectType($projectType);

        return Response::success('Success', 200, []);
    }
}
