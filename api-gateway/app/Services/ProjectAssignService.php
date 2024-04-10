<?php

namespace App\Services;

use App\Models\Assign;
use App\Repositories\ProjectAssignRepository;
use Illuminate\Support\Collection;

class ProjectAssignService {
    public function __construct(private ProjectAssignRepository $projectAssignRepository) {
    }

    public function getAllProjectAssignData(): Collection {
        $allEngineerDataForAssign = $this->projectAssignRepository->getAllProjectAssignData();
        return collect($allEngineerDataForAssign);
    }

    public function search(array $employeeName): Collection {
        $assignList = $this->projectAssignRepository->search($employeeName);
        return collect($assignList);
    }

    public function getDataByYear(int $year): Collection {
        $assignData = $this->projectAssignRepository->getDataByYear($year);
        return $assignData;
    }

    public function saveProjectAssign(array $data): Assign {
        return $this->projectAssignRepository->saveProjectAssign($data);
    }

    public function updateProjectAssign(int $assign_id, array $data): Assign {
        $assign = $this->projectAssignRepository->updateProjectAssign($assign_id, $data);
        return $assign;
    }

    public function getAssignById(int $assignId, int $year, string $emp_cd): array {
        $assignData = $this->projectAssignRepository->getAssignById($assignId, $year, $emp_cd);
        return $assignData;
    }
}