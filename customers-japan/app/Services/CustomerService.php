<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function __construct(private CustomerRepository $customerRepository)
    {
    }
    public function getCustomerList()
    {
        return collect(Customer::all())->map(function ($customer) {
            $customer['location'] = 'Japan';
            return $customer;
        })->all();
    }

    function searchCustomer()
    {
        $customers = QueryBuilder::for(Customer::class)
            ->allowedFilters(['customer_cd', 'customer_name', 'email', 'address'])
            ->get();
        return $customers;
    }


    public function create($request)
    {
        $customerData = [
            'customer_cd' => $request->input('customer_cd'),
            'customer_name' => $request->input('customer_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'modified_date' => $request->input('modified_date'),
        ];
        return DB::table('customermaster')->insert($customerData);
    }

    public function update($customer_cd, $request)
    {
        $customerData = [
            'customer_cd' => $request->input('customer_cd'),
            'customer_name' => $request->input('customer_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'modified_date' => $request->input('modified_date'),
        ];
        return DB::table('customermaster')->where('customer_cd', $customer_cd)->update($customerData);
    }

    public function delete($customer_cd)
    {
        return DB::table('customermaster')->where('customer_cd', $customer_cd)->delete();
    }

    public function getCustomerId($customer_cd)
    {
        return DB::table('customermaster')->select('*')->where('id', $customer_cd)->get();
    }

}