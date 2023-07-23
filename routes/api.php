<?php

use App\Models\Subject;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use App\Models\DefaultSubject;
use App\Models\SubjectTeacher;
use App\Models\TeacherSpecialization;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/specializations', function (Request $request) {
    $specializations = json_decode($request->specializations) ?? [];
    $result = DefaultSubject::getDefaultSubjectsOnly()->whereNotIn('id', $specializations)->take(10)->get();

    if (!count($result)) {
        return response()->json(['message' => 'No results found.'], 404);
    }

    return response()->json(['payload' => $result], 200);
})->name('specializations.get');

Route::post('/teacher_specializations/{id}', function (Request $request, $id) {
    $teacher_id = $id;
    $result = TeacherSpecialization::where('teacher_id', $teacher_id)
        ->join('default_subjects', 'teacher_specializations.specialization_id', '=', 'default_subjects.id')
        ->select('teacher_specializations.*', 'default_subjects.name as name')
        ->get();

    if ($result->isEmpty()) {
        return response()->json(['message' => 'No results found.'], 404);
    }

    return response()->json(['payload' => $result], 200);
})->name('teacher_specializations.get');

Route::post('/teacher_assignment', function (Request $request) {
    $subject_id = json_decode($request->subject_id);
    $teachers = json_decode($request->teachers) ?? [];
    $result = TeacherSpecialization::where('specialization_id', $subject_id)
        ->join('teachers', 'teacher_specializations.teacher_id', 'teachers.id')
        ->join('honorifics', 'teachers.honorific_id', 'honorifics.id')
        ->join('users', 'teachers.user_id', 'users.id')
        ->select('teacher_specializations.*', 'honorifics.honorific', 'users.first_name', 'users.last_name')
        ->whereNotIn('teacher_id', $teachers)
        ->take(10)->get();

    if ($result->isEmpty()) {
        return response()->json(['message' => 'No results found.'], 404);
    }

    return response()->json(['payload' => $result], 200);
})->name('teacher_assignment.get');

Route::post('/create_subject_teacher', function (Request $request) {
    SubjectTeacher::create(['teacher_id' => $request->teacher_id, 'subject_id' => $request->subject_id]);

    return response()->json(['message' => 'Subject_teacher created successfully']);
})->name('teacher_assignment.create');

Route::post('/delete_subject_teacher', function (Request $request) {
    $subjectTeacher = SubjectTeacher::where('teacher_id', $request->teacher_id)
        ->where('subject_id', $request->subject_id)
        ->first();

    if ($subjectTeacher) {
        $subjectTeacher->delete();
        return response()->json(['message' => 'Subject_teacher deleted successfully']);
    } else {
        return response()->json(['message' => 'Subject_teacher not found'], 404);
    }
})->name('teacher_assignment.destroy');

Route::post('/subject_teachers/{id}', function (Request $request, $id) {
    $result = SubjectTeacher::where('subject_id', $id)
        ->join('teachers', 'subject_teachers.teacher_id', 'teachers.id')
        ->join('honorifics', 'teachers.honorific_id', 'honorifics.id')
        ->join('users', 'teachers.user_id', 'users.id')
        ->select('subject_teachers.*', 'honorifics.honorific', 'users.first_name', 'users.last_name')
        ->get();

    return response()->json(['payload' => $result], 200);
})->name('subject_teachers.get');

Route::post('/teachers_by_subject/{id}', function ($id) {
    $result = Subject::where('subjects.id', $id)
    ->join('subject_teachers', 'subject_teachers.subject_id', 'subjects.id')
    ->join('teachers', 'teachers.id', 'subject_teachers.teacher_id')
    ->join('honorifics', 'teachers.honorific_id', 'honorifics.id')
    ->join('users', 'teachers.user_id', 'users.id')
    ->select('teachers.*', 'honorifics.honorific', 'users.first_name', 'users.last_name', 'subject_teachers.id as subject_teacher_id')
    ->get();
    
    return response()->json(['payload' => $result], 200);
});

Route::post('/schedule/store', function(Request $request) {

    $schedules = json_decode($request->schedules);
    foreach($schedules as $schedule) {
        ClassSchedule::where('classroom_id', $schedule->classroom_id)
        ->where('school_year_id', 1)
        ->where('timetable', $schedule->timetable)
        ->where('day_id', $schedule->day_id)
        ->where('period_slot', $schedule->period_slot)
        ->update(['subject_teacher_id' => $schedule->subject_teacher_id]);
    }
});

Route::post('/subjects/{classroom_id}', function ($classroom_id) {
    $result = Classroom::where('classrooms.id', $classroom_id)
        ->join('subjects', 'subjects.gr_level_id', 'classrooms.grade_level_id')
        ->join('default_subjects', 'default_subjects.id', 'subjects.default_subject_id')
        ->where('default_subjects.subject_type_id', 1)
        ->select('subjects.*')
        ->get();

        return response()->json(['payload' => $result], 200);
});