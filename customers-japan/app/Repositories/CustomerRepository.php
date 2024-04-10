<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class CustomerRepository
{
    public function __construct(protected Customer $customer)
    {
    }
    public function getCustomerList(): Collection
    {
        try {
            DB::beginTransaction();
            $customers = collect(Customer::orderBy('customer_name', 'asc')->get())->map(function ($customer) {
                $customer['location'] = 'Japan';
                return $customer;
            })->all();
            DB::commit();
            return $customers;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    function searchCustomer(): Collection
    {
        try {
            DB::beginTransaction();
            $customers = QueryBuilder::for(Customer::class)
                ->allowedFilters(['customer_cd', 'customer_name', 'email', 'address'])
                ->get();
            DB::commit();
            return $customers;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function create($request): bool
    {
        try {
            DB::beginTransaction();
            $customerData = [
                'customer_cd' => $request->input('customer_cd'),
                'customer_name' => $request->input('customer_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'modified_date' => $request->input('modified_date'),
            ];
            $customers = DB::table('customermaster')->insert($customerData);
            DB::commit();
            return $customers;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($customer_cd, $request): bool
    {
        try {
            DB::beginTransaction();
            $customerData = [
                'customer_cd' => $request->input('customer_cd'),
                'customer_name' => $request->input('customer_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'modified_date' => $request->input('modified_date'),
            ];
            $customers = DB::table('customermaster')->where('customer_cd', $customer_cd)->update($customerData);
            DB::commit();
            return $customers;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($customer_cd): bool
    {
        try {
            DB::beginTransaction();
            $customers = DB::table('customermaster')->where('customer_cd', $customer_cd)->delete();
            DB::commit();
            return $customers;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getCustomerId($customer_cd): Collection
    {
        try {
            DB::beginTransaction();
            $customers = DB::table('customermaster')->select('*')->where('id', $customer_cd)->get();
            DB::commit();
            return $customers;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}