<?php

namespace App\Http\Controllers\admin\information;

use Illuminate\Http\Request;
use App\Models\DefaultSubject;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectStoreRequest;
use App\Models\Day;
use App\Models\GradeLevel;
use App\Models\PrioritizedSubjects;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.information.subjects.index', ['subjects' => Subject::getSubjects()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.information.subjects.create', 
            ['default_subjects' => DefaultSubject::getDefaultSubjectsOnly()->get(), 'grade_levels' => GradeLevel::all(), 'days' => Day::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectStoreRequest $request)
    {
        $subject = Subject::create($request->validated());

        if ($request->validated('is_priority') == 1) {
            PrioritizedSubjects::create([
                'subject_id' => $subject->id,
                'priority_time' => $request->validated('priority_time'),
                'priority_day' => $request->validated('priority_day'),]);
        }
        return redirect()->route('admin.information.subjects.index');
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
