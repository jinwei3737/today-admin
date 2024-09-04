<?php

use App\Order\Controller\OrderController;
use App\Order\Controller\OrderSearchController;
use App\Order\Controller\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Order Routes
|--------------------------------------------------------------------------
|
*/

Route::group(["middleware"=>['auth:sanctum']],function (){
    Route::get('order/add', [OrderController::class, 'add']);
    Route::get('order/finish', [OrderController::class, 'finish']);
    Route::get('order/search', [OrderSearchController::class, 'search']);

    Route::get('order/test1', [TestController::class, 'test1']);
    Route::get('order/test2', [TestController::class, 'test2']);
    Route::get('order/test3', [TestController::class, 'test3']);
});
