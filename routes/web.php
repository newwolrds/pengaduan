<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Landing\ComplaintController as LandingComplaintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\UserController;
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
Route::middleware('auth')->group(function() {
    Route::name('complaint.')->prefix('complaint')->group(function() {
        Route::get('', [ComplaintController::class, 'index'])->name('index');
        Route::get('{code}/response', [ComplaintController::class, 'response'])->name('make_response');
        Route::post('store-response', [ComplaintController::class, 'store_response'])->name('store_response');
        Route::put('change-status', [ComplaintController::class, 'change_status'])->name('change_status');
        
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
    
    Route::name('user.')->prefix('user')->group(function() {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('edit/{code}', [UserController::class, 'edit'])->name('edit');
        Route::put('', [UserController::class, 'update'])->name('update');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('', [UserController::class, 'store'])->name('store');
        Route::delete('', [UserController::class, 'delete'])->name('delete');
    });
    
    Route::name('profile.')->prefix('profile')->group(function() {
        Route::get('', [ProfileController::class, 'index'])->name('index');
        Route::put('update-account', [ProfileController::class, 'update_account'])->name('update_account');
        Route::put('update-password', [ProfileController::class, 'update_password'])->name('update_password');
        
    });
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
