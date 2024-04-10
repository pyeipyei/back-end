<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

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
         Http::macro('EmployeeJapanService', function () {
            return Http::withHeaders([
                'EmployeeServiceRoute' => 'api service route',
            ])->baseUrl(config('services.services.employees_japan'))->timeout(2);
        });
    }
}
