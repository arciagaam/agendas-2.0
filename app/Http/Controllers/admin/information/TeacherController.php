<?php

namespace App\Http\Controllers\admin\information;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherStoreRequest;
use App\Models\Adviser;
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
        return view('pages.admin.information.teachers.index', ['teachers' => Teacher::getTeachers()]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
