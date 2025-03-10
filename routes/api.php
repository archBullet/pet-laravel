<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->group(static function () {
        Route::apiResource('/orders', OrderController::class)
            ->names([
                'index' => 'orders.index',
                'show' =>  'orders.show',
                'store' => 'orders.store',
                'update' => 'orders.update',
                'destroy' => 'orders.destroy',
            ]);
    });