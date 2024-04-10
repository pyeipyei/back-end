<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    public function __construct(private ProjectRepository $projectRepository)
    {
    }

    public function getProjects(): Collection
    {
        return $this->projectRepository->getProjects();
    }

    public function getByCustomId(int $custom_id): Collection
    {
        return $this->projectRepository->getByCustomId($custom_id);
    }

    public function getCurrentProjects(): Collection
    {
        return $this->projectRepository->getCurrentProjects();
    }

    public function store(array $data): Project
    {
        return $this->projectRepository->store($data);
    }

    public function getById(int $projectId): Collection
    {
        return $this->projectRepository->getById($projectId);
    }

    public function update(array $data, int $id): Project
    {
        return $this->projectRepository->update($data, $id);
    }

    public function delete(array $ids): Project
    {
        return $this->projectRepository->delete($ids);
    }

    public function filter(): Collection
    {
        return $this->projectRepository->filter();
    }

    public function search(): Collection
    {
        return $this->projectRepository->search();
    }

    public function getCustomerData(object $projectData): Collection
    {
        return $this->projectRepository->getCustomerData($projectData);
    }

    public function getCustomerIdByProjectId(int $projectId)
    {
        return $this->projectRepository->getCustomerIdByProjectId($projectId);
    }
}