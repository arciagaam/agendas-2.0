<?php

namespace App\Http\Controllers\admin\schedules;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassSchedule;
use App\Models\GradeLevel;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(!request()->grade_level_id && request()->classroom_id){
            return redirect()->route('admin.schedules.classes.index');
        }

        return view('pages.admin.schedules.classes.index',[
            'gradeLevels' => GradeLevel::getGradeLevelsOnly()->latest()->get(),
            'sections' => Classroom::classScheduleClassrooms()->latest()->get(),
            'subjects' => Subject::getSubjectsByGradeLevel()->get(),
            'classSchedule' => ClassSchedule::getClassSchedule()->get(),
        ]);
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
