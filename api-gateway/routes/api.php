<?php
 
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EngineerAssignController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectAssignController;
use App\Http\Controllers\MemberTypeController;
use App\Http\Controllers\ActivityController;
 
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 
Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'employees', 'as' => 'employees.'], function () {
        Route::get('/', [EmployeesController::class, 'index']);
        Route::get('/search', [EmployeesController::class, 'search']);
    });
 
    Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
        Route::get('/', [CustomersController::class, 'index']);
        Route::get('/search', [CustomersController::class, 'search']);
    });
 
    Route::group(['prefix' => 'departments', 'as' => 'departments.'], function () {
        Route::get('/', [DepartmentController::class, 'index']);
        Route::post('/', [DepartmentController::class, 'store']);
        Route::get('/{department}', [DepartmentController::class, 'edit']);
        Route::put('/{department}', [DepartmentController::class, 'update']);
        Route::delete('/{department}', [DepartmentController::class, 'destroy']);
    });
 
    Route::group(['prefix' => 'projects', 'as' => 'projects.'], function () {
        Route::get('/', [ProjectController::class, 'index']);
        Route::get('/customer/{custom_id}', [ProjectController::class, 'getByCustomId']);
        Route::get('/current', [ProjectController::class, 'getCurrentProjects']);
        Route::post('/', [ProjectController::class, 'store']);
        Route::get('/{id}/edit', [ProjectController::class, 'edit']);
        Route::put('/{id}', [ProjectController::class, 'update']);
        Route::delete('/delete', [ProjectController::class, 'destroy']);
        Route::get('/filter', [ProjectController::class, 'filter']);
        Route::get('/search', [ProjectController::class, 'search']);
    });
 
    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/search', [RoleController::class, 'search']);
        Route::post('/', [RoleController::class, 'store']);
        Route::get('/{role}', [RoleController::class, 'edit']);
        Route::put('/{role}', [RoleController::class, 'update']);
        Route::delete('/{role}', [RoleController::class, 'destroy']);
    });
 
    Route::group(['prefix' => 'assign', 'as' => 'assign.'], function () {
        Route::post('/engineers', [EngineerAssignController::class, 'store']);
    });
 
    Route::group(['prefix' => 'project_types', 'as' => 'project_types.'], function () {
        Route::get('/', [ProjectTypeController::class, 'index']);
        Route::get('/type/offshore', [ProjectTypeController::class, 'offshore']);
        Route::post('/', [ProjectTypeController::class, 'store']);
        Route::get('/{project_type}', [ProjectTypeController::class, 'edit']);
        Route::put('/{project_type}', [ProjectTypeController::class, 'update']);
        Route::delete('/{project_type}', [ProjectTypeController::class, 'destroy']);
    });
 
    Route::group(['prefix' => 'assign', 'as' => 'assign.'], function () {
        Route::get('/projects', [ProjectAssignController::class, 'index']);
        Route::get('/projects/years/{year}', [ProjectAssignController::class, 'searchYear']);
        Route::post('/projects', [ProjectAssignController::class, 'store']);
        Route::get('/projects/{id}/edit/{year}/{emp_cd}', [ProjectAssignController::class, 'edit']);
        Route::put('/projects/{id}', [ProjectAssignController::class, 'update']);
        Route::get('/projects/search', [ProjectAssignController::class, 'search']);
    });
 
    Route::group(['prefix' => 'costs', 'as' => 'costs.'], function () {
        Route::get('/', [CostController::class, 'index']);
        Route::get('/cost/{project_id}', [CostController::class, 'detail']);
        Route::get('/costSummary', [CostController::class, 'costSummary']);
        Route::get('/costSummary/years/{year}', [CostController::class, 'costSummarySearch']);
    });
 
    Route::group(['prefix' => 'member', 'as' => 'member.'], function () {
        Route::get('type/', [MemberTypeController::class, 'index']);
    });
 
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/engineerStatus/{year}/{month}', [DashboardController::class, 'getEngineerStatus']);
        Route::get('/yearlyIncome', [DashboardController::class, 'yearlyIncome']);
        Route::get('/yearlyIncome/years/{year}', [DashboardController::class, 'filterYearlyIncome']);
        Route::get('/monthlyIncome/years/{year}', [DashboardController::class, 'monthlyIncome']);
    });
 
    Route::group(['prefix' => 'activity', 'as' => 'activity.'], function () {
        Route::get('/', [ActivityController::class, 'index']);
    });
 
    Route::post('/auth/update_password', [AuthController::class, 'updatePassword']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
 
Route::post('/auth/verify_email', [AuthController::class, 'verifyEmail']);
// set route for new user register
Route::post('/auth/register', [AuthController::class, 'register']);
// set route for user login
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/reset_password', [AuthController::class, 'resetPassword']);
Route::post('/auth/check_confirmation_code', [AuthController::class, 'checkConfirmationCode']);
Route::post('/auth/reset_password_using_email', [AuthController::class, 'resetPasswordUsingEmail']);