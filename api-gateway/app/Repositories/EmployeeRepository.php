<?php

namespace App\Repositories;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Carbon;

class EmployeeRepository
{
    public function getAllEmployee(): Response
    {
        try {
            $limiter = app(RateLimiter::class);
            $actionKey = 'select_all_emmployees';
            $threshold = 10;// Define the rate limit threshold
            // Check if the rate limit is exceeded
            if ($limiter->tooManyAttempts($actionKey, $threshold)) {
                // Exceeded the maximum number of failed attempts.
                return $this->failOrFallback();
            }
            // Perform an HTTP GET request with the configured base URL
            return Http::EmployeeService()->get('/employees');
        } catch (Exception $e) {
            $limiter->hit($actionKey, Carbon::now()->addMinutes(15));
            return $this->failOrFallback();
        }
    }

    public function searchEmployee(array $filter): Response
    {
        try {
            $limiter = app(RateLimiter::class);
            $actionKey = 'search_records';
            // Define the rate limit threshold
            $threshold = 10;
            // Check if the rate limit is exceeded
            if ($limiter->tooManyAttempts($actionKey, $threshold)) {
                // Exceeded the maximum number of failed attempts.
                return $this->failOrFallback();
            }
            // Perform an HTTP GET request with the configured base URL
            return Http::EmployeeService()->get('/employees/search', ['filter' => $filter]);
        } catch (Exception $e) {
            $limiter->hit($actionKey, Carbon::now()->addMinutes(15));
            return $this->failOrFallback();
        }
    }

    protected function failOrFallback()
    {
        // Handle the failure or provide a fallback
        return Response::error('Failed to fetch data', 500);
    }
}