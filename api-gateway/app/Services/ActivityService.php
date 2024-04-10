<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use App\Repositories\ActivityRepository;

class ActivityService {
    private $activityRepository;

    public function __construct(ActivityRepository $activityRepository) {
        $this->activityRepository = $activityRepository;
    }

    public function activity(): Collection {
        return $this->activityRepository->activity();
    }
}