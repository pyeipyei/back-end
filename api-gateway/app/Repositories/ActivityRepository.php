<?php

namespace App\Repositories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ActivityRepository {
    public function __construct(protected Activity $activity) {
    }

    public function activity(): Collection {
        try {
            DB::beginTransaction();
            $activity = Activity::all();
            DB::commit();
            return $activity;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}