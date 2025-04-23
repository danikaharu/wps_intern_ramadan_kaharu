<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {

    // Dashboard
    Route::get('dashboard', ['App\Http\Controllers\Admin\DashboardController', 'index'])->name('dashboard');
    // Kalender Event Route
    Route::get('/dashboard/logs/calendar', [App\Http\Controllers\Admin\DashboardController::class, 'calendarEvents'])->name('log.calendar');

    // Detail Log 
    Route::get('/dashboard/logs/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'showLogDetail'])->name('log.detail');

    // Activity
    Route::resource('activity', App\Http\Controllers\Admin\ActivityController::class);
    Route::put('/activity/{activity}/status/{status}', [App\Http\Controllers\Admin\ActivityController::class, 'updateStatus'])->name('activity.updateStatus');

    // User
    Route::resource('user', App\Http\Controllers\Admin\UserController::class);

    // Role
    Route::resource('role', App\Http\Controllers\Admin\RoleController::class);

    // Profile 
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
});
