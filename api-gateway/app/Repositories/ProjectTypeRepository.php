<?php

namespace App\Repositories;

use App\Models\ProjectType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProjectTypeRepository
{
    public function __construct(protected ProjectType $projectType)
    {
    }

    public function getAllProjectTypes(): Collection
    {
        try {
            DB::beginTransaction();

            $projectTypes = ProjectType::all();

            DB::commit();

            return $projectTypes;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function offshore(): Collection
    {
        try {
            DB::beginTransaction();
            $ses = ['SES'];
            $projectTypes = ProjectType::whereNotIn('project_type', $ses)->get();

            DB::commit();

            return $projectTypes;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function createProjectType(array $projectTypeData): ProjectType
    {
        try {
            DB::beginTransaction();

            $projectType = ProjectType::create([
                'project_type' => $projectTypeData['project_type'],
            ]);

            DB::commit();

            return $projectType;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getProjectTypeById(int $id): ?ProjectType
    {
        try {
            DB::beginTransaction();

            $projectType = ProjectType::find($id);

            DB::commit();

            return $projectType;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateProjectType(ProjectType $projectType, array $projectTypeData): bool
    {
        try {
            DB::beginTransaction();

            $result = $projectType->update([
                'project_type' => $projectTypeData['project_type'],
            ]);

            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteProjectType(ProjectType $projectType): void
    {
        try {
            DB::beginTransaction();
            $projectType->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}