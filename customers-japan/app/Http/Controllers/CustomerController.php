<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(private CustomerService $customerService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = $this->customerService->getCustomerList();
        $meta = ["status"=>200,"msg"=>"Success"];
        return response()->json(
            [
                'meta' => $meta,
                'data' => $customers,
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function search()
    {
        $customers = $this->customerService->searchCustomer();
        return response()->json($customers,200);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $customers = $this->customerService->create($request);
        return response()->json($customers,200);
    }

    /**
     *  Update the specified resource in storage.
     */
    public function update(String $customer_cd,Request $request)
    {
        $customers = $this->customerService->update($customer_cd,$request);
        return response()->json($customers,200);
    }

    public function show(String $customer_cd)
    
    {
        $customerId = $this->customerService->getCustomerId($customer_cd);
        return response()->json($customerId,200);
        
    }
    /**
     *  Remove the specified resource from storage.
     */
    public function delete(String $customer_cd)
    {
        $customers = $this->customerService->delete($customer_cd);
        return response()->json($customers,200);
    }
    
}
