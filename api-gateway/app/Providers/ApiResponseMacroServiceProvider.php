<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ApiResponseMacroServiceProvider extends ServiceProvider
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
        // Success response macro
        Response::macro('success', function ($message, $statusCode, $data) {
            return response()->json(['meta' => ['status' => $statusCode, 'msg' => $message], 'data' => $data]);
        });

        // Error response macro
        Response::macro('error', function ($message, $statusCode) {
            return response()->json(['meta' => ['status' => $statusCode, 'msg' => $message]]);
        });
    }
}