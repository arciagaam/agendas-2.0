<?php

use App\Models\DefaultSubject;
use App\Models\TeacherSpecialization;
use Illuminate\Http\Request;
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
