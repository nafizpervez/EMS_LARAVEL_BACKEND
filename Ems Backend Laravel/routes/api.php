<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SaleForcastsController;
use App\Http\Controllers\InventoriesController;
use App\Http\Controllers\ConveyancesController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\PurchaseRequisitionsController;
use App\Http\Controllers\TodosController;
use App\Http\Controllers\CalendarEventsController;
use App\Http\Controllers\ApprovalRequestsController;
use App\Http\Controllers\ExtendedUserDetailsController;
use App\Http\Controllers\InfoController;

use Illuminate\Support\Facades\Storage;


use App\Http\Controllers\MailsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Login
Route::post('sanctum/token', [AuthController::class, 'login']);

// For Authenticated user
Route::middleware(['auth:sanctum'])->group(function () {
    //getUser
    Route::get('user_auth', [AuthController::class, 'getUser']);

    //Logout
    Route::get('user_auth/revoke', [AuthController::class, 'logout']);

    Route::put('users/change_password/{user}', [UsersController::class, 'changePassword']);

    // activate or deactivate account
    Route::put('users/deactivate/{user}', [UsersController::class, 'deactivate']);
    Route::put('users/activate/{user}', [UsersController::class, 'activate']);

    Route::apiResource('users', UsersController::class)->except(['update']);
    Route::resource('roles', RolesController::class);
    Route::resource('sale_forcasts', SaleForcastsController::class);
    Route::resource('inventories', InventoriesController::class)->except(['update']);
    Route::resource('conveyances', ConveyancesController::class);
    Route::resource('leaves', LeavesController::class)->except(['update']);
    Route::resource('purchase_requisitions', PurchaseRequisitionsController::class)->except(['update']);
    Route::resource('todos', TodosController::class);
    Route::resource('calendar_events', CalendarEventsController::class);
    Route::resource('approval_requests', ApprovalRequestsController::class);
    Route::resource('extended_details', ExtendedUserDetailsController::class);

    Route::middleware(['fileUpdate'])->prefix('update')->group(function () {
        Route::post('users/{user}', [UsersController::class, 'update']);
        Route::post('inventories/{inventory}', [InventoriesController::class, 'update']);
        Route::post('leaves/{leave}', [LeavesController::class, 'update']);
        Route::post('purchase_requisitions/{purchase_requisition}', [PurchaseRequisitionsController::class, 'update']);
    });

    Route::prefix('information')->group(function () {
        Route::get('employee_count', [InfoController::class, 'employeeCount']);
        Route::get('funnel_project_val', [InfoController::class, 'funnelVal']);
        Route::get('on_leave', [InfoController::class, 'onLeave']);
        Route::get('all_user_summary', [InfoController::class, 'allUserSummary']);
        Route::get('announcements', [InfoController::class, 'announcements']);
    });

});

Route::get('images/{imageLink}', function ($imageLink) {
    $pic = Storage::get('public/images/avatars/'.$imageLink);
    return $pic;
});

Route::get('attachments/{attachmentLink}', function ($attachmentLink) {
    $file = Storage::get('public/files/attachments/'.$attachmentLink);
    return $file;
});
