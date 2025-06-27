<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/acquisitions', [\App\Http\Controllers\AcquisitionController::class, 'index'])
    ->name('acquisitions.index');
Route::post('/acquisitions/import', [\App\Http\Controllers\AcquisitionController::class, 'import'])
    ->name('acquisitions.import');

// Route::group( function () {
//     Route::post('/acquisitions/import', [\App\Http\Controllers\AcquisitionController::class, 'import'])
//         ->name('acquisitions.import');
    
//     // Route::get('/acquisitions/{acquisition}', [\App\Http\Controllers\AcquisitionController::class, 'show'])
//     //     ->name('acquisitions.show');
    
//     // Route::put('/acquisitions/{acquisition}', [\App\Http\Controllers\AcquisitionController::class, 'update'])
//     //     ->name('acquisitions.update');
    
//     // Route::delete('/acquisitions/{acquisition}', [\App\Http\Controllers\AcquisitionController::class, 'destroy'])
//     //     ->name('acquisitions.destroy');
// });
