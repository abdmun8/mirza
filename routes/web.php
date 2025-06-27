<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AcquisitionController;

// Route::get('/', function () {
//     // return Inertia::render('welcome');
//     return Inertia::render('acquisition');
// })->name('home');

Route::get('/', [AcquisitionController::class, 'index'])->name('acquisition.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
