<?php

use App\Order\Controller\OrderController;
use App\Order\Controller\OrderSearchController;
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
});
