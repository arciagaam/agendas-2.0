<?php

namespace App\Http\Controllers\admin\information;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherStoreRequest;
use App\Models\Adviser;
use App\Models\Honorific;
use App\Models\TeacherSpecialization;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.information.teachers.index', [
            'teachers' => Teacher::getTeachers()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.information.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherStoreRequest $request)
    {
        $createdUser = User::create([...$request->validated(), 'password' => bcrypt('password'), 'user_type_id' => 2]);

        $teacher = Teacher::create([...$request->validated(), 'user_id' => $createdUser->id]);

        if ($request->specializations) {
            foreach ($request->specializations as $specialization) {
                TeacherSpecialization::create(['teacher_id' => $teacher->id, 'specialization_id' => $specialization]);
            }
        }

        if ($request->validated('is_adviser') == 1) {
            Adviser::create(['teacher_id' => $teacher->id, 'classroom_id' => null]);
        }

        return redirect()->route('admin.information.teachers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $isAdviser = Adviser::where('teacher_id', $teacher->id)->exists();

        return view('pages.admin.information.teachers.edit', [
            'teacher' => $teacher,
            'honorifics' => Honorific::all(),
            'user_details' => User::getUserDetails($teacher->user_id)->first(),
            'isAdviser' => $isAdviser]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeacherStoreRequest $request, Teacher $teacher)
    {
        $teacher->fill($request->validated());
        $user_details = $teacher->user;
        $user_details->fill($request->validated());

        // dd($user_details->isDirty());
        if ($user_details->isDirty()) {
            $user_details->update($request->validated());
        }

        if ($teacher->isDirty()) {
            $teacher->update($request->validated());
        }


        if ($request->specializations) {
            $existing_specializations = TeacherSpecialization::where('teacher_id', $teacher->id)->get();

            if ($existing_specializations->count() > 0) {
                foreach ($existing_specializations as $existing_specialization) {
                    $existing_specialization->delete();
                }
            }

            foreach ($request->specializations as $specialization) {
                TeacherSpecialization::create(['teacher_id' => $teacher->id, 'specialization_id' => $specialization]);
            }
        }

         $existing_adviser = Adviser::where('teacher_id', $teacher->id)->exists();

         if ($request->validated('is_adviser') == 1 && !$existing_adviser) {
            Adviser::create(['teacher_id' => $teacher->id, 'classroom_id' => null]);
        } else if ($existing_adviser && $request->validated('is_adviser') == 0) {
            Adviser::where('teacher_id', $teacher->id)->delete();
        }

        return redirect()->route('admin.information.teachers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
