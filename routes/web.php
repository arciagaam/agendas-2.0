<?php

use App\Http\Controllers\admin\user_management\AccountController;
use App\Http\Controllers\admin\user_management\RoleController;
use App\Http\Controllers\admin\assignment\TeacherController as AssignmentTeacherController;
use App\Http\Controllers\admin\information\BuildingController;
use App\Http\Controllers\admin\information\DashboardController;
use App\Http\Controllers\admin\information\RoomController;
use App\Http\Controllers\admin\information\ClassroomController;
use App\Http\Controllers\admin\information\SubjectController;
use App\Http\Controllers\admin\information\TeacherController;
use App\Http\Controllers\admin\information\TemplateController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\schedules\ClassController;
use App\Http\Controllers\admin\schedules\EventController;
use App\Http\Controllers\admin\schedules\ExamController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\SystemVariableController;
use App\Models\ClassSchedule;
use App\Models\Teacher;
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

Route::get('/clearall', function() {
    ClassSchedule::where('subject_teacher_id', '!=', null)->update(['subject_teacher_id' => null]);
    session()->forget('unsaved.schedule');
    return back()->with('clear', true);
})->name('clearall');

Route::get('/updateregularload', function () {
    Teacher::where('regular_load', 10)->update(['regular_load' => 20]);
})->name('updateregularload');


Route::get('/', [AuthenticationController::class, 'userLogin']);
Route::post('/authenticate', [AuthenticationController::class, 'authenticate'])->name('authenticate'); 
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout'); 




Route::prefix('admin')->name('admin.')->group(function() {

    Route::get('/', [AuthenticationController::class, 'adminLogin']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('information')->name('information.')->group(function() {
        Route::resource('buildings', BuildingController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('classrooms', ClassroomController::class);
        Route::post('schedule-templates/store', [TemplateController::class, 'store']);
        Route::resource('schedule-templates', TemplateController::class)->only(['index', 'create']);
        Route::resource('teachers', TeacherController::class);
        Route::resource('subjects', SubjectController::class);
    });

    Route::prefix('assignments')->name('assignments.')->group(function() {
        Route::resource('teachers', AssignmentTeacherController::class);
    });

    Route::prefix('schedules')->name('schedules.')->group(function() {
        Route::prefix('classes')->name('classes.')->group(function() {
            Route::post('/store-session', [ClassController::class, 'storeSession']);
            Route::get('/remove-session/{classroomId}', [ClassController::class, 'removeSession']);
            Route::get('/save', [ClassController::class, 'save']);
            Route::get('/automate', [ClassController::class, 'automate'])->name('automate');
        });
        Route::resource('classes', ClassController::class);


        Route::resource('events', EventController::class);
        Route::resource('exams', ExamController::class);
    });

    Route::resource('reports', ReportController::class);

    Route::resource('system-variables', SystemVariableController::class);

    Route::prefix('user-management')->name('user-management.')->group(function() {
        Route::resource('accounts', AccountController::class);
        Route::resource('roles', RoleController::class);
    });

});


// gumawa ng middleware for user and admin

Route::middleware(['guest'])->group(function () {
    
});

Route::middleware(['auth'])->group(function () {
    
});
