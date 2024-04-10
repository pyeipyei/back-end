<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use Illuminate\Http\Client\Response;

class CustomerService
{
    public function __construct(private CustomerRepository $customerRepository) {}

    public function getAllCustomer(): Response
    {
        return $this->customerRepository->getAllCustomer();
    }

    public function searchCustomer(array $filter): Response
    {
        return $this->customerRepository->searchCustomer($filter);
    }
}
