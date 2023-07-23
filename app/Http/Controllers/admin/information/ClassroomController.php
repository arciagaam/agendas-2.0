<?php

namespace App\Http\Controllers\admin\information;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomStoreRequest;
use App\Models\Adviser;
use App\Models\Classroom;
use App\Models\GradeLevel;
use App\Models\Room;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.information.classrooms.index', ['classrooms' => Classroom::getClassrooms()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.information.classrooms.create', [
            'rooms' => Room::get(), 
            'grade_levels' => GradeLevel::getGradeLevelsOnly()->get(), 
            'advisers' => Adviser::getAdvisers()->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassroomStoreRequest $request)
    {
        $classroom = Classroom::create($request->validated());

        if ($request->adviser_id) {
            Adviser::where('id', $request->adviser_id)->update(['classroom_id' => $classroom->id]);
        }
        return redirect()->route('admin.information.classrooms.index');
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
    public function edit(Classroom $classroom)
    {
        $adviser = Adviser::where('classroom_id', $classroom->id)->first();
        return view('pages.admin.information.classrooms.edit', [
            'classroom' => $classroom, 
            'rooms' => Room::get(), 
            'grade_levels' => GradeLevel::getGradeLevelsOnly()->get(), 
            'advisers' => Adviser::getAdvisers()->get(),
            'classroom_adviser' => $adviser]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassroomStoreRequest $request, Classroom $classroom)
    {
        $classroom->update($request->validated());

        if ($request->adviser_id) {
            Adviser::where('classroom_id', $classroom->id)->update(['classroom_id' => null]);
            Adviser::where('id', $request->adviser_id)->update(['classroom_id' => $classroom->id]);
        }
        return redirect()->route('admin.information.classrooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
