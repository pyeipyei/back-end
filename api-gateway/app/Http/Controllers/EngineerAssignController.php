<?php

namespace App\Http\Controllers;

use App\Events\EngineerAssignEvent;
use App\Http\Requests\EngineerAssignRequest;
use App\Services\EngineerAssignService;
use Illuminate\Support\Facades\Response;

class EngineerAssignController extends Controller {
    public function __construct(private EngineerAssignService $engineerAssignService) {
    }

    public function store(EngineerAssignRequest $request) {
        try {
            // call service to save data
            $data = $request->validated();
            $result = $this->engineerAssignService->saveEngineerAssign($data);
            event(new EngineerAssignEvent($result));
            return Response::success('Success', 200, []);
        } catch (\Exception $e) {
            // Handle exceptions and errors
            return Response::error($e->getMessage(), 500);
        }
    }
}
