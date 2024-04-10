<?php

namespace App\Services;

use App\Repositories\DashboardRepository;

class DashboardService
{
    public function __construct(private DashboardRepository $dashboardRepository)
    {
    }

    public function getData(): array
    {
        return $this->dashboardRepository->getDashboardData();
    }

    public function yearlyIncome(): object
    {
        return $this->dashboardRepository->yearlyIncome();
    }

    public function filterYearlyIncome(int $year): object
    {
        return $this->dashboardRepository->filterYearlyIncome($year);
    }

    public function monthlyIncome(int $year)
    {
        return $this->dashboardRepository->monthlyIncome($year);
    }

    public function getEngineerStatus(int $year, int $month): array
    {
        return $this->dashboardRepository->getEngineerStatus($year, $month);
    }
}