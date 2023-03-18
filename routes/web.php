<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Landing\ComplaintController as LandingComplaintController;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::name('admin_dashboard.')->prefix('admin-dashboard')->group(function() {
    Route::get('', [AdminDashboardController::class, 'index'])->name('index');
});

Route::name('complaint.')->prefix('complaint')->group(function() {
    Route::get('', [ComplaintController::class, 'index'])->name('index');
    Route::get('edit/{code}', [ComplaintController::class, 'edit'])->name('edit');
    Route::put('{code}', [ComplaintController::class, 'update'])->name('update');
    Route::get('create', [ComplaintController::class, 'create'])->name('create');
    Route::post('', [ComplaintController::class, 'store'])->name('store');
    Route::delete('', [ComplaintController::class, 'delete'])->name('delete');
});

Route::name('response.')->prefix('response')->group(function() {
    Route::get('', [ResponseController::class, 'index'])->name('index');
    Route::get('edit/{code}', [ResponseController::class, 'edit'])->name('edit');
    Route::put('{code}', [ResponseController::class, 'update'])->name('update');
    Route::get('create', [ResponseController::class, 'create'])->name('create');
    Route::post('', [ResponseController::class, 'store'])->name('store');
    Route::delete('', [ResponseController::class, 'delete'])->name('delete');
});
Route::name('landing.')->group(function() {
    Route::name('complaint.')->prefix('complaint')->group(function() {
        Route::post('', [ComplaintController::class, 'store'])->name('store');
    });
    Route::name('my_complaint.')->prefix('my-complaint')->group(function() {
        Route::get('', [LandingComplaintController::class, 'index'])->name('index');
    });
    
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
