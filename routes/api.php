<?php

use App\Http\Controllers\BatchItemController;
use App\Http\Controllers\BatchItemItemsOutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\BatchItemDispatchController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/batches', [BatchController::class, 'index']);
    Route::post('/batches', [BatchController::class, 'store']);
    Route::get('/batches/{batch}', [BatchController::class, 'show']);
    Route::put('/batches/{batch}', [BatchController::class, 'update']);
    Route::delete('/batches/{batch}', [BatchController::class, 'destroy']);
    Route::post('/batches/upload', [BatchController::class, 'upload']);

    Route::get('/batches/{batch}/items', [BatchItemController::class, 'index']);

    Route::put('/batches/{batch}/dispatch', [BatchItemDispatchController::class, 'update']);
    Route::put('/batches/{batch}/items-out', [BatchItemItemsOutController::class, 'update']);
});
