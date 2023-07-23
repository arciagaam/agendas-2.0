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
        return view('pages.admin.information.subjects.index', [
            'subjects' => Subject::getSubjects(),
            'grade_levels' => GradeLevel::getGradeLevelsOnly()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.information.subjects.create', [
            'default_subjects' => DefaultSubject::getDefaultSubjectsOnly()->get(), 
            'grade_levels' => GradeLevel::all(), 
            'days' => Day::all()]);
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
    public function edit(Subject $subject)
    {
        $priority_details = PrioritizedSubjects::where('subject_id', $subject->id)->first();
        return view('pages.admin.information.subjects.edit', [
            'subject' => $subject,
            'default_subjects' => DefaultSubject::getDefaultSubjectsOnly()->get(), 
            'grade_levels' => GradeLevel::all(), 
            'days' => Day::all(),
            'priority_details' => $priority_details]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectStoreRequest $request, Subject $subject)
    {
        //Syncing of request data to model
        $priority_details = $subject->prioritizedSubjects;
        $subject->fill($request->validated());
                
        //Check if subject exists on prioritized subjects
        $isExisting = PrioritizedSubjects::where('subject_id', $subject->id)->exists(); 

        if ($subject->isDirty()) {
            $subject->update($request->validated());
        }

        $priority_details->fill($request->validated());
        
        if ($request->validated('is_priority') == 1 && $isExisting && $priority_details->isDirty()) {
            
            PrioritizedSubjects::where('subject_id', $subject->id)->update([
                'priority_time' => $request->validated('priority_time'),
                'priority_day' => $request->validated('priority_day'),
            ]);
        } elseif ($request->validated('is_priority') == 1 && !$isExisting) {
            PrioritizedSubjects::create([
                'subject_id' => $subject->id,
                'priority_time' => $request->validated('priority_time'),
                'priority_day' => $request->validated('priority_day'),]);
        } elseif ($request->validated('is_priority') == 0 && $isExisting) {
            PrioritizedSubjects::where('subject_id', $subject->id)->delete();
        }

        return redirect()->route('admin.information.subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
