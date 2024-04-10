<?php

namespace App\Services;

use App\Repositories\CostRepository;
use Illuminate\Database\Eloquent\Collection;

class CostService
{
    private $costRepository;

    public function __construct(CostRepository $costRepository)
    {
        $this->costRepository = $costRepository;
    }

    public function index(): array
    {
        return $this->costRepository->index();
    }

    public function detailAssigned(int $project_id)
    {
        return $this->costRepository->detailAssigned($project_id);
    }

    public function detailProject(int $project_id)
    {
        return $this->costRepository->detailProject($project_id);

    }

    public function search(): Collection
    {
        return $this->costRepository->search();
    }

    public function costSummary(): array
    {
        return $this->costRepository->costSummary();
    }

    public function costSummarySearch(int $year): array
    {
        return $this->costRepository->costSummarySearch($year);
    }
}