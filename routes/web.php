<?php

use App\Http\Controllers\CreditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Feature1Controller;
use App\Http\Controllers\Feature2Controller;
use App\Http\Controllers\Feature3Controller;
use App\Http\Controllers\Feature4Controller;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/buy-credits/webhook', [CreditController::class, 'webhook'])->name('credit.webhook');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/feature1', [Feature1Controller::class, 'index'])->name('feature1.index');
    Route::get('/feature2', [Feature2Controller::class, 'index'])->name('feature2.index');
    Route::post('/feature1/calculate', [Feature1Controller::class, 'calculate'])->name('feature1.calculate');
    Route::post('/feature2/calculate', [Feature2Controller::class, 'calculate'])->name('feature2.calculate');

    Route::get('/feature3', [Feature3Controller::class, 'index'])->name('feature3.index');
    Route::get('/feature4', [Feature4Controller::class, 'index'])->name('feature4.index');
    Route::post('/feature3/calculate', [Feature3Controller::class, 'calculate'])->name('feature3.calculate');
    Route::post('/feature4/calculate', [Feature4Controller::class, 'calculate'])->name('feature4.calculate');

    Route::get('/buy-credits', [CreditController::class, 'index'])->name('credits.index');
    Route::get('/buy-credits/success', [CreditController::class, 'success'])->name('credits.success');
    Route::get('/buy-credits/cancel', [CreditController::class, 'cancel'])->name('credits.cancel');

    Route::post('/buy-credits/{package}', [CreditController::class, 'buyCredits'])->name('credits.buy');
});

require __DIR__.'/auth.php';
