<?php

namespace App\Http\Controllers;

use App\Events\CostEvent;
use App\Http\Resources\CostResource;
use App\Services\CostService;
use Illuminate\Support\Facades\Response;

class CostController extends Controller
{
    public function __construct(private CostService $costService)
    {
        $this->costService = $costService;
    }

    public function index()
    {
        $costs = $this->costService->index();
        $result[0] = 'Selected';
        $result[1] = 'Project Cost Data in Cost screen';
        event(new CostEvent($result));
        return response()->json($costs, 200);
    }

    public function detail(int $project_id)
    {
        $assignCost = $this->costService->detailAssigned($project_id);
        $estimateCost = $this->costService->detailProject($project_id);
        $data = [$estimateCost, $assignCost];
        $result[0] = 'Selected';
        $result[1] = 'Project Cost Data by Project Id ' . $project_id . ' in Cost screen';
        event(new CostEvent($result));
        return response()->json($data, 200);
    }

    public function search()
    {
        try {
            $searchCostInfo = $this->costService->search();
            $result[0] = 'Search';
            $result[1] = 'Project Cost Data by Project Name in Cost screen';
            event(new CostEvent($result));
            return new CostResource($searchCostInfo);
        } catch (\Exception $e) {
            return Response::error('An error occurred', 500);
        }
    }

    public function costSummary()
    {
        try {
            $data = $this->costService->costSummary();
            $result[0] = 'Selected';
            $result[1] = 'Project Cost Summary Data in Cost Summary screen';
            event(new CostEvent($result));
            return [
                'meta' => [
                    'status' => 200,
                    'msg' => 'Success',
                ],
                'data' => $data,
            ];
        } catch (\Exception $e) {
            return Response::error('An error occurred', 500);
        }
    }

    public function costSummarySearch(int $year)
    {
        try {
            $data = $this->costService->costSummarySearch($year);
            $result[0] = 'Selected';
            $result[1] = 'Project Cost Summary ' . $year . ' Data in Cost Summary screen';
            event(new CostEvent($result));
            return [
                'meta' => [
                    'status' => 200,
                    'msg' => 'Success',
                ],
                'data' => $data,
            ];
        } catch (\Exception $e) {
            return Response::error('An error occurred', 500);
        }
    }
}
