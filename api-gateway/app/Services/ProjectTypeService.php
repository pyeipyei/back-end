<?php

namespace App\Services;

use App\Models\ProjectType;
use App\Repositories\ProjectTypeRepository;
use Illuminate\Database\Eloquent\Collection;

class ProjectTypeService
{
   public function __construct(private ProjectTypeRepository $projectTypeRepository)
   {
   }

   public function getAllProjectTypes(): Collection
   {
      return $this->projectTypeRepository->getAllProjectTypes();
   }

   public function offshore(): Collection
   {
      return $this->projectTypeRepository->offshore();
   }

   public function createProjectType(array $projectTypeData): ProjectType
   {
      return $this->projectTypeRepository->createProjectType($projectTypeData);
   }

   public function getProjectTypeById(int $id): ?ProjectType
   {
      return $this->projectTypeRepository->getProjectTypeById($id);
   }

   public function updateProjectType(ProjectType $projectType, array $projectTypeData): bool
   {
      return $this->projectTypeRepository->updateProjectType($projectType, $projectTypeData);
   }

   public function deleteProjectType(ProjectType $projectType): void
   {
      $this->projectTypeRepository->deleteProjectType($projectType);
   }
}