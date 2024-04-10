<?php

namespace App\Http\Controllers;

use App\Events\DashboardEvent;
use Illuminate\Support\Facades\Response;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {
    }

    public function index()
    {
        try {
            $data = $this->dashboardService->getData();
            $meta = ["status" => 200, "msg" => "Success"];
            $dashboard[0] = "Selected";
            $dashboard[1] = "Dashboard data";
            event(new DashboardEvent($dashboard));
            return response()->json(
                [
                    'meta' => $meta,
                    'data' => $data,
                ]
            );
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function yearlyIncome()
    {
        try {
            $data = $this->dashboardService->yearlyIncome();
            $meta = ["status" => 200, "msg" => "Success"];
            return response()->json(
                [
                    'meta' => $meta,
                    'data' => $data,
                ]
            );
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function filterYearlyIncome(int $year)
    {
        try {
            $data = $this->dashboardService->filterYearlyIncome($year);
            $meta = ["status" => 200, "msg" => "Success"];
            return response()->json(
                [
                    'meta' => $meta,
                    'data' => $data,
                ]
            );
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function monthlyIncome(int $year)
    {
        try {
            $data = $this->dashboardService->monthlyIncome($year);
            $meta = ["status" => 200, "msg" => "Success"];
            return response()->json(
                [
                    'meta' => $meta,
                    'data' => $data,
                ]
            );
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    public function getEngineerStatus(int $year, int $month)
    {
        try {
            $data = $this->dashboardService->getEngineerStatus($year, $month);
            $meta = ["status" => 200, "msg" => "Success"];
            return response()->json(
                [
                    'meta' => $meta,
                    'data' => $data,
                ]
            );
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }
}
