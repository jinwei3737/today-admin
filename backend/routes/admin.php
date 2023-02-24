<?php

use App\Admin\Controllers\AuthController;
use App\Admin\Controllers\PermissionsController;
use App\Admin\Controllers\RolesController;
use App\Admin\Controllers\OrderController;
use App\Admin\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::match(['GET', 'POST'], '/login', [AuthController::class, 'login']);

Route::group(["middleware" => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('info', [AuthController::class, 'info']);

    Route::get('order/add', [OrderController::class, 'add']);
    Route::get('order/finish', [OrderController::class, 'finish']);

    Route::get('user/view_data', [UsersController::class, 'addOrEditViewData']);
    Route::get('role/view_data', [RolesController::class, 'addOrEditViewData']);
    Route::get('menu/view_data', [PermissionsController::class, 'addOrEditViewData']);

    Route::group(["middleware" => ['permission']], function () {
        Route::get('users', [UsersController::class, 'index']);
        Route::post('user/add', [UsersController::class, 'add']);
        Route::get('user/detail', [UsersController::class, 'detail']);
        Route::post('user/edit', [UsersController::class, 'edit']);
        Route::post('user/delete', [UsersController::class, 'delete']);
        Route::post('user/remove_role', [UsersController::class, 'removeRole']);
        Route::post('user/remove_permission', [UsersController::class, 'removePermission']);

        Route::get('roles', [RolesController::class, 'index']);
        Route::post('role/add', [RolesController::class, 'add']);
        Route::get('role/detail', [RolesController::class, 'detail']);
        Route::post('role/edit', [RolesController::class, 'edit']);
        Route::post('role/delete', [RolesController::class, 'delete']);
        Route::post('role/remove_permission', [RolesController::class, 'removePermission']);

        Route::get('menus', [PermissionsController::class, 'index']);
        Route::post('menu/add', [PermissionsController::class, 'add']);
        Route::get('menu/detail', [PermissionsController::class, 'detail']);
        Route::post('menu/edit', [PermissionsController::class, 'edit']);
        Route::post('menu/delete', [PermissionsController::class, 'delete']);
    });
});
