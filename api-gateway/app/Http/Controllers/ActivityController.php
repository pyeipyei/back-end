<?php

namespace App\Http\Controllers;

use App\Services\ActivityService;
use App\Http\Resources\ActivityResource;
use Illuminate\Support\Facades\Response;

class ActivityController extends Controller {
    public function __construct(private ActivityService $activityService) {
    }

    public function index() {
        try {
            $responseData = $this->activityService->activity();
            return new ActivityResource($responseData);
        } catch (\Exception $e) {
            // Handle exceptions and errors
            return Response::error($e->getMessage(), 500);
        }
    }
}
