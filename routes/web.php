<?php

use App\Http\Controllers\Backend\Accounts\Ledger\LedgerController;
use App\Http\Controllers\Backend\Accounts\Master_Ledger\MasterLedgerController;
use App\Http\Controllers\Backend\Accounts\Sub_Ledger\SubLedgerController;
use App\Http\Controllers\Backend\Accounts\Transaction\TransactionController;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Customer\CustomerController;
use App\Http\Controllers\Backend\Student\ExamRoutine_controller;
use App\Http\Controllers\Backend\Supplier\Supplier_invoiceController;
use App\Http\Controllers\Backend\Supplier\Supplier_returnController;
use App\Http\Controllers\Backend\Customer\InvoiceController;
use App\Http\Controllers\Backend\Customer\TicketController;
use App\Http\Controllers\Backend\Product\BrandController;
use App\Http\Controllers\Backend\Product\CategoryController;
use App\Http\Controllers\Backend\Product\SubCateogryController;
use App\Http\Controllers\Backend\Product\ColorController;
use App\Http\Controllers\Backend\Product\ProductController;
use App\Http\Controllers\Backend\Product\TempImageController;
use App\Http\Controllers\Backend\Product\ChildCategoryController;
use App\Http\Controllers\Backend\Product\SizeController;
use App\Http\Controllers\Backend\Product\StockController;
use App\Http\Controllers\Backend\Product\StoreController;
use App\Http\Controllers\Backend\Product\UnitController;
use App\Http\Controllers\Backend\Settings\Website\BannerController;
use App\Http\Controllers\Backend\Settings\Website\GalleryController;
use App\Http\Controllers\Backend\Settings\Website\SliderController;
use App\Http\Controllers\Backend\Settings\Website\SpeechController;
use App\Http\Controllers\Backend\Student\Attendance_controller;
use App\Http\Controllers\Backend\Student\Bill_CollectionController;
use App\Http\Controllers\Backend\Student\classController;
use App\Http\Controllers\Backend\Student\ClassRoutine_controller;
use App\Http\Controllers\Backend\Student\Exam_controller;
use App\Http\Controllers\Backend\Student\Exam_result_controller;
use App\Http\Controllers\Backend\Student\Fees_type_controller;
use App\Http\Controllers\Backend\Student\Leave_controller;
use App\Http\Controllers\Backend\Teacher\Leave\Leave_controller as teacher_leave_controller;
use App\Http\Controllers\Backend\Student\SectionController;
use App\Http\Controllers\Backend\Student\Shift_controller;
use App\Http\Controllers\Backend\Student\StudentController;
use App\Http\Controllers\Backend\Student\Subject_controller;
use App\Http\Controllers\Backend\Supplier\SupplierController;
use App\Http\Controllers\Backend\Teacher\TeacherAttendance_controller;
use App\Http\Controllers\Backend\Teacher\TeacherController;
use App\Http\Controllers\Backend\Teacher\Transaction\TeacherTransaction_controller;
use App\Http\Controllers\Backend\Tickets\Assign_Controller;
use App\Http\Controllers\Backend\Tickets\Complain_typeController;
use App\Http\Controllers\Backend\Tickets\Ticket_controller;
use App\Models\Product_Category;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
require __DIR__.'/Frontend.php';
/*Backend Route*/
Route::get('/admin/login', [AdminController::class, 'login_form'])->name('admin.login');
Route::post('login-functionality',[AdminController::class,'login_functionality'])->name('login.functionality');
Route::group(['middleware'=>'admin'],function(){
    Route::get('/admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('admin/logout',[AdminController::class,'logout'])->name('admin.logout');
    Route::post('/admin/get_dashboard_data',[AdminController::class,'get_data'])->name('admin.dashboard_get_all_data');

    /** Student Management  Route **/
    Route::prefix('admin/student')->group(function(){
        /** Section  Route **/
        Route::prefix('section')->group(function(){
            Route::controller(SectionController::class)->group(function(){
                Route::get('/list','index')->name('admin.student.section.index');
                Route::get('/all_data','all_data')->name('admin.student.section.all_data');
                Route::get('/edit/{id}','edit')->name('admin.student.section.edit');
                Route::post('/update','update')->name('admin.student.section.update');
                Route::post('/store','store')->name('admin.student.section.store');
                Route::post('/delete','delete')->name('admin.student.section.delete');
            });
        });
        /** Class  Route **/
        Route::prefix('class')->group(function(){
            Route::controller(classController::class)->group(function(){
                Route::get('/list','index')->name('admin.student.class.index');
                Route::get('/all_data','all_data')->name('admin.student.class.all_data');
                Route::get('/edit/{id}','edit')->name('admin.student.class.edit');
                Route::post('/update','update')->name('admin.student.class.update');
                Route::post('/store','store')->name('admin.student.class.store');
                Route::post('/delete','delete')->name('admin.student.class.delete');
            });
            /** Class  Routine route **/
            Route::prefix('routine')->group(function(){
                Route::controller(ClassRoutine_controller::class)->group(function(){
                    Route::get('/list','index')->name('admin.student.class.routine.index');
                    Route::get('/all_data','all_data')->name('admin.student.class.routine.all_data');
                    Route::get('/edit/{id}','edit')->name('admin.student.class.routine.edit');
                    Route::post('/update','update')->name('admin.student.class.routine.update');
                    Route::post('/store','store')->name('admin.student.class.routine.store');
                    Route::post('/delete','delete')->name('admin.student.class.routine.delete');
                    Route::get('/print','print')->name('admin.student.class.routine.print');
                    Route::get('/get_routine_data','get_routine_data')->name('admin.student.class.routine.data');

                });
            });
        });
        /** Subject  Route **/
        Route::prefix('subject')->group(function(){
            Route::controller(Subject_controller::class)->group(function(){
                Route::get('/list','index')->name('admin.student.subject.index');
                Route::get('/all_data','all_data')->name('admin.student.subject.all_data');
                Route::get('/edit/{id}','edit')->name('admin.student.subject.edit');
                Route::post('/update','update')->name('admin.student.subject.update');
                Route::post('/store','store')->name('admin.student.subject.store');
                Route::post('/delete','delete')->name('admin.student.subject.delete');
                Route::post('/get_subject_by_class','get_subject_by_class')->name('admin.student.subject.get_subject_by_class');
            });
        });
        /** Examination  Route **/
        Route::prefix('examination')->group(function(){
            Route::controller(Exam_controller::class)->group(function(){
                Route::get('/list','index')->name('admin.student.exam.index');
                Route::get('/all_data','get_all_data')->name('admin.student.exam.get_all_data');
                Route::get('/edit/{id}','edit')->name('admin.student.exam.edit');
                Route::post('/update/{id}','update')->name('admin.student.exam.update');
                Route::post('/store','store')->name('admin.student.exam.store');
                Route::post('/delete','delete')->name('admin.student.exam.delete');
            });
        });
        /** Examination Routine  Route **/
        Route::prefix('examination/routine')->group(function(){
            Route::controller(ExamRoutine_controller::class)->group(function(){
                Route::get('/list','index')->name('admin.student.exam.routine.index');
                Route::get('/all_data','get_all_data')->name('admin.student.exam.routine.get_all_data');
                Route::get('/edit/{id}','edit')->name('admin.student.exam.routine.edit');
                Route::post('/update/{id}','update')->name('admin.student.exam.routine.update');
                Route::post('/store','store')->name('admin.student.exam.routine.store');
                Route::post('/delete','delete')->name('admin.student.exam.routine.delete');
                Route::post('/get_exam_routine','get_exam_routine')->name('admin.student.exam.routine.get_exam_routine');
            });
        });
        /** Examination Result  Route **/
        Route::prefix('examination/result')->group(function(){
            Route::controller(Exam_result_controller::class)->group(function(){
                Route::get('/create','create_result')->name('admin.student.exam.result.create');
                Route::get('/report','result_report')->name('admin.student.exam.result.report');
                Route::get('/edit/{id}','edit')->name('admin.student.exam.result.edit');
                Route::post('/update','update')->name('admin.student.exam.result.update');
                Route::post('/store','result_store')->name('admin.student.exam.result.store');
                Route::post('/get_exam_result','get_exam_result')->name('admin.student.exam.result.get_result');
                Route::post('/delete','delete')->name('admin.student.exam.result.delete');
            });
        });
        /** Student  Route **/
        Route::controller(StudentController::class)->group(function(){
            Route::get('/create','create')->name('admin.student.create');
            Route::post('/store','store')->name('admin.student.store');
            Route::get('/all_data','all_data')->name('admin.student.all_data');
            Route::get('/list','index')->name('admin.student.index');
            Route::get('/edit/{id}','edit')->name('admin.student.edit');
            Route::post('/update/{id}','update')->name('admin.student.update');
            Route::post('/delete','delete')->name('admin.student.delete');
            Route::get('/view/{id}','view')->name('admin.student.view');
            Route::get('/get_student/{id}','get_student')->name('admin.student.get_student');
            Route::post('/student_filter','student_filter')->name('admin.student.student_filter');
        });

        /*Student Shift */
        Route::prefix('shift')->group(function(){
            Route::controller(Shift_controller::class)->group(function(){
                Route::get('/index','index')->name('admin.student.shift.index');
                 Route::get('/all_data','all_data')->name('admin.student.shift.all_data');
                 Route::post('/store','store')->name('admin.student.shift.store');
                 Route::post('/update','update')->name('admin.student.shift.update');
                 Route::post('/delete','delete')->name('admin.student.shift.delete');
                 Route::get('/get_shift/{id}','get_shift')->name('admin.student.shift.get_shift');
            });
        });
        /*Student Leave */
        Route::prefix('leave')->group(function(){
            Route::controller(Leave_controller::class)->group(function(){
                Route::get('/index','index')->name('admin.student.leave.index');
                Route::get('/all_data','all_data')->name('admin.student.leave.all_data');
                Route::post('/store','store')->name('admin.student.leave.store');
                Route::post('/update','update')->name('admin.student.leave.update');
                Route::post('/delete','delete')->name('admin.student.leave.delete');
                Route::get('/get_leave/{id}','get_leave')->name('admin.student.leave.get_leave');
            });
        });
        /*Student Attendence */
        Route::prefix('attendence')->group(function(){
            Route::controller(Attendance_controller::class)->group(function(){
                Route::get('/index','index')->name('admin.student.attendence.index');
                Route::post('/store','store')->name('admin.student.attendence.store');
                Route::post('/update','update')->name('admin.student.attendence.update');
                Route::post('/delete','delete')->name('admin.student.attendence.delete');
                Route::get('/get_attendance/{id}','get_attendance')->name('admin.student.attendence.get_attendance');
                Route::get('/log','attendance_log')->name('admin.student.attendence.log');
                Route::post('/report','attendance_report')->name('admin.student.attendence.report');
            });
        });
        /*Student Fees Type */
        Route::prefix('Fees_type')->group(function(){
            Route::controller(Fees_type_controller::class)->group(function(){
                Route::get('/index','index')->name('admin.student.fees_type.index');
                Route::get('/all_data','all_data')->name('admin.student.fees_type.all_data');
                Route::post('/store','store')->name('admin.student.fees_type.store');
                Route::post('/update','update')->name('admin.student.fees_type.update');
                Route::post('/delete','delete')->name('admin.student.fees_type.delete');
                Route::get('/get_fees_type/{id}','get_fees_type')->name('admin.student.fees_type.get_fees_type');
                Route::get('/get_fees_for_class/{id}','get_fees_for_class')->name('admin.student.fees_type.get_fees_for_class');
            });
        });

        /*Student Bill Collection */
        Route::prefix('Bill_collection')->group(function(){
            Route::controller(Bill_CollectionController::class)->group(function(){
                Route::get('/index','index')->name('admin.student.bill_collection.index');
                Route::get('/all_data','all_data')->name('admin.student.bill_collection.all_data');
                Route::get('/create','create_bill')->name('admin.student.bill_collection.create');
                Route::post('/store','store')->name('admin.student.bill_collection.store');
                Route::post('/delete','delete')->name('admin.student.bill_collection.delete');
                Route::get('/edit/{id}','edit')->name('admin.student.bill_collection.edit');
                Route::post('/update/{id}','update')->name('admin.student.bill_collection.update');
                Route::get('Invoice/view/{id}','invoice_show')->name('admin.student.bill_collection.invoice_show');
                Route::get('student/due_amount/{student_id}','get_student_due_amount')->name('admin.student.get_student_due_amount');
            });

        });

    });
     /** Teacher Management  Route **/
    Route::prefix('admin/teacher')->group(function(){
        Route::controller(TeacherController::class)->group(function(){
            Route::get('/create','create')->name('admin.teacher.create');
            Route::post('/store','store')->name('admin.teacher.store');
            Route::get('/list','index')->name('admin.teacher.index');
            Route::get('/all_data','all_data')->name('admin.teacher.all_data');
            Route::get('/edit/{id}','edit')->name('admin.teacher.edit');
            Route::post('/update/{id}','update')->name('admin.teacher.update');
            Route::post('/delete','delete')->name('admin.teacher.delete');
            Route::get('/view/{id}','view')->name('admin.teacher.view');
        });
        /*Teacher Transaction  */
        Route::prefix('Transaction')->group(function(){
            Route::controller(TeacherTransaction_controller::class)->group(function(){
                Route::get('/index','index')->name('admin.teacher.transaction.index');
                 Route::get('/all_data','all_data')->name('admin.teacher.transaction.all_data');
                 Route::post('/store','store')->name('admin.teacher.transaction.store');
                 Route::post('/update','update')->name('admin.teacher.transaction.update');
                 Route::post('/delete','delete')->name('admin.teacher.transaction.delete');
                 Route::get('/get_transaction/{id}','get_transaction')->name('admin.teacher.transaction.get_transaction');
                Route::get('/report','report')->name('admin.teacher.transaction.report');
                Route::post('/report_generate','report_generate')->name('admin.teacher.transaction.report_generate');
            });
        });
        /*Teacher Leave  */
        Route::prefix('leave')->group(function(){
            Route::controller(teacher_leave_controller::class)->group(function(){
                Route::get('/index','index')->name('admin.teacher.leave.index');
                Route::get('/all_data','all_data')->name('admin.teacher.leave.all_data');
                Route::post('/store','store')->name('admin.teacher.leave.store');
                Route::post('/update','update')->name('admin.teacher.leave.update');
                Route::post('/delete','delete')->name('admin.teacher.leave.delete');
                Route::get('/get_leave/{id}','get_leave')->name('admin.teacher.leave.get_leave');
            });
        });
        /*Teacher Attendance  */
        Route::prefix('attendence')->group(function(){
            Route::controller(TeacherAttendance_controller::class)->group(function(){
                Route::get('/index','index')->name('admin.teacher.attendence.index');
                Route::get('/all_data','all_data')->name('admin.teacher.attendence.all_data');
                 Route::post('/store','store')->name('admin.teacher.attendence.store');
                Route::get('/log','attendance_log')->name('admin.teacher.attendence.log');
                Route::get('/attendance_log_all_data','attendance_log_all_data')->name('admin.teacher.attendence.log.all_data');
            });
        });

    });
     /** Tickets  Route **/
     Route::prefix('admin/ticket')->group(function(){
        /*Complain Type */
        Route::prefix('complain_type')->group(function(){
            Route::controller(Complain_typeController::class)->group(function(){
                Route::get('/list', 'index')->name('admin.tickets.complain_type.index');
                Route::get('/all-data', 'get_all_data')->name('admin.tickets.complain_type.get_all_data');
                Route::get('/edit/{id}', 'edit')->name('admin.tickets.complain_type.edit');
                Route::post('/delete', 'delete')->name('admin.tickets.complain_type.delete');
                Route::post('/store', 'store')->name('admin.tickets.complain_type.store');
                Route::post('/update/{id}', 'update')->name('admin.tickets.complain_type.update');
            });
        });
        /*Assign To */
        Route::prefix('assign')->group(function(){
            Route::controller(Assign_Controller::class)->group(function(){
                Route::get('/list', 'index')->name('admin.tickets.assign.index');
                Route::get('/all-data', 'get_all_data')->name('admin.tickets.assign.get_all_data');
                Route::get('/edit/{id}', 'edit')->name('admin.tickets.assign.edit');
                Route::post('/delete', 'delete')->name('admin.tickets.assign.delete');
                Route::post('/store', 'store')->name('admin.tickets.assign.store');
                Route::post('/update/{id}', 'update')->name('admin.tickets.assign.update');

            });
        });
         /*Ticket Route To */
        Route::controller(Ticket_controller::class)->group(function(){
            Route::get('/list', 'index')->name('admin.tickets.index');
            Route::get('/all-data', 'get_all_data')->name('admin.tickets.get_all_data');
            Route::get('/edit/{id}', 'edit')->name('admin.tickets.edit');
            Route::post('/delete', 'delete')->name('admin.tickets.delete');
            Route::post('/store', 'store')->name('admin.tickets.store');
            Route::post('/update/{id}', 'update')->name('admin.tickets.update');
        });
     });
    /** Accounts Management  Route **/
    Route::prefix('admin/accounts')->group(function(){

        /** Master Ledger Route **/
        Route::prefix('master_ledger')->group(function(){
            Route::controller(MasterLedgerController::class)->group(function(){
                Route::get('/list','index')->name('admin.master_ledger.index');
                Route::get('/get_all_data','get_all_data')->name('admin.master_ledger.all_data');
                Route::get('/edit/{id}','edit')->name('admin.master_ledger.edit');
                Route::post('/update','update')->name('admin.master_ledger.update');
                Route::post('/store','store')->name('admin.master_ledger.store');
                Route::post('/delete','delete')->name('admin.master_ledger.delete');
            });
        });
        /**Ledger Route **/
        Route::prefix('ledger')->group(function(){
            Route::controller(LedgerController::class)->group(function(){
                Route::get('/list','index')->name('admin.ledger.index');
                Route::get('/get_all_data','get_all_data')->name('admin.ledger.all_data');
                Route::get('/edit/{id}','edit')->name('admin.ledger.edit');
                Route::post('/store','store')->name('admin.ledger.store');
                Route::post('/update','update')->name('admin.ledger.update');
                Route::post('/delete','delete')->name('admin.ledger.delete');
                /*get  ledger from master ledger id*/
                Route::get('/get/{id}','get_ledger')->name('admin.ledger.get_ledger');
            });
        });
        /**Sub Ledger Route **/
        Route::prefix('sub_ledger')->group(function(){
            Route::controller(SubLedgerController::class)->group(function(){
                Route::get('/list','index')->name('admin.sub_ledger.index');
                Route::get('/get_all_data','get_all_data')->name('admin.sub_ledger.all_data');
                Route::get('/edit/{id}','edit')->name('admin.sub_ledger.edit');
                Route::post('/store','store')->name('admin.sub_ledger.store');
                Route::post('/update','update')->name('admin.sub_ledger.update');
                Route::post('/delete','delete')->name('admin.sub_ledger.delete');
                /*get sub ledger from ledger id*/
                Route::get('/get/{id}','get_sub_ledger')->name('admin.sub_ledger.get_sub_ledger');
            });
        });
        /*Transaction Route*/
        Route::prefix('transaction')->group(function(){
            Route::controller(TransactionController::class)->group(function(){
                Route::get('/list','index')->name('admin.transaction.index');
                Route::post('/store','store')->name('admin.transaction.store');
                Route::get('/report','transaction_report')->name('admin.transaction.report.index');
                Route::post('/report_generate','report_generate')->name('admin.accounts.transaction.report_generate');
                Route::get('/show','show_account_transaction')->name('admin.transaction.show');
                Route::post('/finished','finished_account_transaction')->name('admin.transaction.finished');
            });
        });
    });
    /** Customer Route **/
    Route::prefix('admin/customer')->group(function() {
        Route::controller(CustomerController::class)->group(function() {
            Route::get('/list', 'index')->name('admin.customer.index');
            Route::get('/all-data', 'get_all_data')->name('admin.customer.get_all_data');
            Route::get('/edit/{id}', 'edit')->name('admin.customer.edit');
            Route::get('/view/{id}', 'view')->name('admin.customer.view');
            Route::post('/delete', 'delete')->name('admin.customer.delete');
            Route::post('/store', 'store')->name('admin.customer.store');
            Route::post('/update/{id}', 'update')->name('admin.customer.update');
        });

        /** Customer Invoice Route **/
        Route::prefix('invoice')->controller(InvoiceController::class)->group(function() {
            Route::get('/create', 'create_invoice')->name('admin.customer.invoice.create_invoice');
            Route::get('/get_all_data', 'show_invoice_data')->name('admin.customer.invoice.show_invoice_data');
            Route::get('/show', 'show_invoice')->name('admin.customer.invoice.show_invoice');
            Route::post('/pay', 'pay_due_amount')->name('admin.customer.invoice.pay_due_amount');
            Route::post('/store', 'store_invoice')->name('admin.customer.invoice.store_invoice');
            Route::get('/view/{id}', 'view_invoice')->name('admin.customer.invoice.view_invoice');
            Route::get('/edit/{id}', 'edit_invoice')->name('admin.customer.invoice.edit_invoice');
            Route::post('/update', 'update_invoice')->name('admin.customer.invoice.update_invoice');
            Route::post('/delete', 'delete_invoice')->name('admin.customer.invoice.delete_invoice');
        });
        /** Customer Ticket Route **/
        Route::prefix('ticket')->controller(TicketController::class)->group(function() {
            Route::get('/list', 'index')->name('admin.customer.tickets.index');
            Route::get('/all-data', 'get_all_data')->name('admin.customer.tickets.get_all_data');
            Route::get('/edit/{id}', 'edit')->name('admin.customer.tickets.edit');
            Route::post('/delete', 'delete')->name('admin.customer.tickets.delete');
            Route::post('/store', 'store')->name('admin.customer.tickets.store');
            Route::post('/update/{id}', 'update')->name('admin.customer.tickets.update');
        });
    });
    /** Supplier Route **/
    Route::prefix('admin/supplier')->group(function(){
        Route::controller(SupplierController::class)->group(function(){
            Route::get('/list', 'index')->name('admin.supplier.index');
            Route::get('/all-data', 'get_all_data')->name('admin.supplier.get_all_data');
            Route::get('/create', 'create')->name('admin.supplier.create');
            Route::get('/edit/{id}', 'edit')->name('admin.supplier.edit');
            Route::get('/view/{id}', 'view')->name('admin.supplier.view');
            Route::post('/delete', 'delete')->name('admin.supplier.delete');
            Route::post('/store', 'store')->name('admin.supplier.store');
            Route::post('/update/{id}', 'update')->name('admin.supplier.update');
        });
        /** Supplier Invoice Route **/
        Route::prefix('invoice')->controller(Supplier_invoiceController::class)->group(function() {
            Route::get('/create', 'create_invoice')->name('admin.supplier.invoice.create_invoice');
            Route::get('/get_all_data', 'show_invoice_data')->name('admin.supplier.invoice.show_invoice_data');
            Route::post('/search_data', 'search_product_data')->name('admin.supplier.invoice.search_product_data');
            Route::get('/show', 'show_invoice')->name('admin.supplier.invoice.show_invoice');
            Route::post('/pay', 'pay_due_amount')->name('admin.supplier.invoice.pay_due_amount');
            Route::post('/store', 'store_invoice')->name('admin.supplier.invoice.store_invoice');
            Route::get('/view/{id}', 'view_invoice')->name('admin.supplier.invoice.view_invoice');
            Route::get('/edit/{id}', 'edit_invoice')->name('admin.supplier.invoice.edit_invoice');
            Route::post('/update', 'update_invoice')->name('admin.supplier.invoice.update_invoice');
            Route::post('/delete', 'delete_invoice')->name('admin.supplier.invoice.delete_invoice');
        });
    });

    /* Product Route */
    Route::prefix('admin/product')->group(function() {
        /* Sub Category Route */
        Route::prefix('sub-category')->controller(SubCateogryController::class)->group(function() {
            Route::get('/', 'index')->name('admin.subcategory.index');
            Route::post('/store', 'store')->name('admin.subcategory.store');
            Route::get('/edit/{id}', 'edit')->name('admin.subcategory.edit');
            Route::post('/delete', 'delete')->name('admin.subcategory.delete');
            Route::post('/update/{id}', 'update')->name('admin.subcategory.update');
            Route::get('/get-sub_category/{id}', 'get_sub_category');
        });

        /* Child Category Route */
        Route::prefix('child-category')->controller(ChildCategoryController::class)->group(function() {
            Route::get('/', 'index')->name('admin.childcategory.index');
            Route::post('/store', 'store')->name('admin.childcategory.store');
            Route::get('/edit/{id}', 'edit')->name('admin.childcategory.edit');
            Route::post('/delete', 'delete')->name('admin.childcategory.delete');
            Route::post('/update/{id}', 'update')->name('admin.childcategory.update');
            Route::get('/get-child_category/{id}', 'get_child_category');
        });

        /** Product Color Management Route **/
        Route::prefix('color')->controller(ColorController::class)->group(function() {
            Route::get('/', 'index')->name('admin.product.color.index');
            Route::get('/get_all_data', 'get_all_data')->name('admin.product.color.all_data');
            Route::post('/store', 'store')->name('admin.product.color.store');
            Route::get('/edit/{id}', 'edit')->name('admin.product.color.edit');
            Route::post('/update', 'update')->name('admin.product.color.update');
            Route::post('/delete', 'delete')->name('admin.product.color.delete');
        });

        /** Product Size Management Route **/
        Route::prefix('size')->controller(SizeController::class)->group(function() {
            Route::get('/', 'index')->name('admin.product.size.index');
            Route::get('/get_all_data', 'get_all_data')->name('admin.product.size.all_data');
            Route::post('/store', 'store')->name('admin.product.size.store');
            Route::get('/edit/{id}', 'edit')->name('admin.product.size.edit');
            Route::post('/update', 'update')->name('admin.product.size.update');
            Route::post('/delete', 'delete')->name('admin.product.size.delete');
        });
         /** Product Unit Management Route **/
        Route::prefix('unit')->controller(UnitController::class)->group(function() {
            Route::get('/list', 'index')->name('admin.unit.index');
            Route::get('/all-data', 'get_all_data')->name('admin.unit.get_all_data');
            Route::get('/edit/{id}', 'edit')->name('admin.unit.edit');
            Route::post('/delete', 'delete')->name('admin.unit.delete');
            Route::post('/store', 'store')->name('admin.unit.store');
            Route::post('/update/{id}', 'update')->name('admin.unit.update');
        });
         /** Product Category Management Route **/
        Route::prefix('category')->controller(CategoryController::class)->group(function() {
            Route::get('/list', 'index')->name('admin.category.index');
            Route::get('/all-data', 'get_all_data')->name('admin.category.get_all_data');
            Route::get('/edit/{id}', 'edit')->name('admin.category.edit');
            Route::post('/delete', 'delete')->name('admin.category.delete');
            Route::post('/store', 'store')->name('admin.category.store');
            Route::post('/update/{id}', 'update')->name('admin.category.update');
        });
         /** Product Brand Management Route **/
        Route::prefix('brand')->controller(BrandController::class)->group(function() {
            Route::get('/list', 'index')->name('admin.brand.index');
            Route::get('/all-data', 'get_all_data')->name('admin.brand.get_all_data');
            Route::get('/edit/{id}', 'edit')->name('admin.brand.edit');
            Route::post('/delete', 'delete')->name('admin.brand.delete');
            Route::post('/store', 'store')->name('admin.brand.store');
            Route::post('/update/{id}', 'update')->name('admin.brand.update');
        });
        /** Product Store Management Route **/
        Route::prefix('store')->controller(StoreController::class)->group(function() {
            Route::get('/list', 'index')->name('admin.store.index');
            Route::get('/all-data', 'get_all_data')->name('admin.store.get_all_data');
            Route::get('/edit/{id}', 'edit')->name('admin.store.edit');
            Route::post('/delete', 'delete')->name('admin.store.delete');
            Route::post('/store', 'store')->name('admin.store.store');
            Route::post('/update/{id}', 'update')->name('admin.store.update');
        });

        /* Product Route */
        Route::controller(ProductController::class)->group(function() {
            Route::get('/list', 'index')->name('admin.product.index');
            Route::get('/all-data', 'get_all_data')->name('admin.product.get_all_data');
            Route::get('/edit/{id}', 'edit')->name('admin.product.edit');
            Route::get('/view/{id}', 'product_view')->name('admin.product.view');
            Route::post('/delete', 'delete')->name('admin.product.delete');
            Route::post('/store', 'store')->name('admin.product.store');
            Route::post('/update/{id}', 'update')->name('admin.product.update');
            Route::post('/check_product_qty', 'check_product_qty')->name('admin.product.check_product_qty');
        });

        /* Product Image */
        Route::prefix('photo')->controller(ProductController::class)->group(function() {
            Route::post('/upload-temp-image', [TempImageController::class, 'create'])->name('tempimage.create');
            Route::post('/update', 'photo_update')->name('admin.product.photo.update');
            Route::post('/delete', 'delete_photo')->name('admin.product.delete.photo');
        });

        /* Stock Route */
        Route::get('/stock', [StockController::class, 'index'])->name('admin.product.stock.index');
    });

    /** Settings Management  Route **/
    Route::prefix('admin/settings/website/')->group(function(){
        /** Banner Route **/
        Route::prefix('banner')->group(function(){
            Route::controller(BannerController::class)->group(function(){
                Route::get('/list','index')->name('admin.settings.website.banner.index');
                 Route::get('/get_all_data','get_all_data')->name('admin.settings.website.banner.get_all_data');
                Route::get('/edit/{id}','edit')->name('admin.settings.website.banner.edit');
                Route::post('/update','update')->name('admin.settings.website.banner.update');
                Route::post('/store','store')->name('admin.settings.website.banner.store');
                Route::post('/delete','delete')->name('admin.settings.website.banner.delete');
            });
        });
        /** Slider Route **/
        Route::prefix('slider')->group(function(){
            Route::controller(SliderController::class)->group(function(){
                Route::get('/list','index')->name('admin.settings.website.slider.index');
                 Route::get('/get_all_data','get_all_data')->name('admin.settings.website.slider.get_all_data');
                Route::get('/edit/{id}','edit')->name('admin.settings.website.slider.edit');
                Route::post('/update','update')->name('admin.settings.website.slider.update');
                Route::post('/store','store')->name('admin.settings.website.slider.store');
                Route::post('/delete','delete')->name('admin.settings.website.slider.delete');
            });
        });
        /** Speech Route **/
        Route::prefix('speech')->group(function(){
            Route::controller(SpeechController::class)->group(function(){
                Route::get('/list','index')->name('admin.settings.website.speech.index');
                Route::get('/get_all_data','get_all_data')->name('admin.settings.website.speech.get_all_data');
                Route::get('/edit/{id}','edit')->name('admin.settings.website.speech.edit');
                Route::post('/update','update')->name('admin.settings.website.speech.update');
                Route::post('/store','store')->name('admin.settings.website.speech.store');
                Route::post('/delete','delete')->name('admin.settings.website.speech.delete');
            });
        });
        /** Gallery Route **/
        Route::prefix('gallery')->group(function(){
            Route::controller(GalleryController::class)->group(function(){
                Route::get('/list','index')->name('admin.settings.website.gallery.index');
                Route::post('/store','store')->name('admin.settings.website.gallery.store');
                Route::post('/delete/{id}','delete')->name('admin.settings.website.gallery.delete');
            });
        });
    });
    Route::get('/optimize',function(){
        Artisan::call('optimize:clear');
        return 'Optimize Clear Completed';
    });

});
