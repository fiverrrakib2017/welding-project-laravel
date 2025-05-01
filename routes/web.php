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
            Route::get('/get_all_data', 'get_all_data')->name('admin.student.get_all_data');
            Route::get('/create', 'create')->name('admin.student.create');
            Route::get('/edit/{student_id}', 'edit')->name('admin.student.edit');
            Route::post('/update/{student_id}', 'update')->name('admin.student.update');

            /*Student Delete*/
            Route::post('/delete', 'delete')->name('admin.student.delete');
            Route::post('/recycle_delete', 'recycle_delete')->name('admin.student.recycle.delete');

            Route::post('/store', 'store')->name('admin.student.store');
            Route::get('/course_list', 'course_list')->name('admin.student.course.list');
            Route::get('/logs', 'student_logs')->name('admin.student.log.index');
            Route::get('/logs/get_all_data', 'student_log_get_all_data')->name('admin.student.log.get_all_data');
            Route::get('/student_recycle', 'student_recycle')->name('admin.student.recycle.index');
            Route::post('/change_status/{id}', 'change_status')->name('admin.student.change_status');

        });
    });
    Route::get('management/user',function(){
        return view('Backend.Pages.User.index');
    })->name('admin.user.management.index');

    Route::get('/optimize', function () {
        Artisan::call('optimize:clear');
        return 'Optimize Clear Completed';
    });

});
Route::get('/student/certificate/{student_id}', [studentController::class, 'student_certificate'])->name('admin.student.certificate');

