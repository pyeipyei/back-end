<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;


class HttpClientMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Define a macro to set a common base URL for requests
        Http::macro('EmployeeService', function () {
            return Http::withHeaders([
                'EmployeeServiceRoute' => 'api service route',
            ])->baseUrl(config('services.services.employees_myanmar'))->timeout(2);
        });

        Http::macro('EmployeeJapanService', function () {
            return Http::withHeaders([
                'EmployeeServiceRoute' => 'api service route',
            ])->baseUrl(config('services.services.employees_japan'))->timeout(2);
        });

        Http::macro('CustomerService', function () {
            return Http::withHeaders([
                'CustomerServiceRoute' => 'api service route',
            ])->baseUrl(config('services.services.customer_japan'))->timeout(2);
        });
    }
}