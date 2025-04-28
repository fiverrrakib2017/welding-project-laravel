<?php

use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Router\RouterController;
use App\Http\Controllers\Backend\Sms\SmsController;
use App\Http\Controllers\Backend\Student\studentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
/*Backend Route*/
Route::get('/admin/login', [AdminController::class, 'login_form'])->name('admin.login');
Route::post('login-functionality', [AdminController::class, 'login_functionality'])->name('login.functionality');
Route::group(['middleware' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::post('/admin/get_dashboard_data', [AdminController::class, 'get_data'])->name('admin.dashboard_get_all_data');


    /* Student Management Route */
    Route::prefix('student')->group(function () {
       Route::controller(studentController::class)->group(function () {
            Route::get('/list', 'index')->name('admin.student.index');
            Route::get('/create', 'create')->name('admin.student.create');
            Route::post('/store', 'store')->name('admin.student.store');
        });
    });
    Route::get('/optimize', function () {
        Artisan::call('optimize:clear');
        return 'Optimize Clear Completed';
    });

});
