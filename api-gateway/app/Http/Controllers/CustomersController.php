<?php

namespace App\Http\Controllers;

use App\Events\CustomerEvent;
use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CustomersController extends Controller
{
    public function __construct(private CustomerService $customerService)
    {
    }

    /**
     * get customer's data
     *
     * @return JsonResponse customer list
     */
    public function index()
    {
        try {
            $response = $this->customerService->getAllCustomer();
            $customer[0] = "Selected";
            $customer[1] = "Customer List Data";
            event(new CustomerEvent($customer));
            return $response;
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }

    /**
     * get customer's data
     *
     * @return JsonResponse customer list
     */
    public function search(Request $request)
    {
        try {
            $filter = $request->query('filter', []);
            $response = $this->customerService->searchCustomer($filter);
            $customer[0] = "Searched";
            $customer[1] = "Customer Data by " . key($filter);
            event(new CustomerEvent($customer));
            return $response;
        } catch (\Exception $e) {
            return Response::error($e->getMessage(), 500);
        }
    }
}
