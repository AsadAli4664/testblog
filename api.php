<?php

use App\Http\Controllers\Portal\ChartsController;
use App\Http\Controllers\Portal\CustomNotificationController;
use App\Http\Controllers\Portal\DashboardController;
use App\Http\Controllers\Portal\PageContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/page-content'], function () {
    Route::get('/datatable/list', [PageContentController::class, 'list'])->name('admin.page-content.list');
});
/*Route::group(['prefix' => '/custom-notifications'], function () {
    Route::get('/datatable/list', [CustomNotificationController::class, 'list'])->name('admin.page-content.list');
});
*/

Route::get('/daily-signups', [ChartsController::class, 'dailySignups']);
Route::get('/dashboard-stats', [DashboardController::class, 'dashboardStats']);
