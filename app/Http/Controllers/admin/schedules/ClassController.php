<?php

namespace App\Http\Controllers\admin\schedules;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassSchedule;
use App\Models\GradeLevel;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
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
            'subjects' => Subject::getSubjectsByGradeLevel()->with([
                'defaultSubject',
                'subjectTeachers' => [
                    'teacher.user',
                    'teacher.honorific'
                ]
            ])->get(),
            'classSchedule' => session()->missing("unsaved.schedule.".request()->classroom_id) ? ClassSchedule::getClassSchedule()->get() : collect(session("unsaved.schedule.".request()->classroom_id)),
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

    public function storeSession() {
        $schedule = json_decode(request()->schedule);
        $classroomId = $schedule[0]->classroom_id;
        session(["unsaved.schedule.$classroomId" => $schedule]);
    }

    public function removeSession($classroomId) {
        session()->forget("unsaved.schedule.$classroomId");
    }

    public function save() {
        $this->saveSchedule();
        return response(['message' => 'Schedule successfully saved.', 200]);
    }

    public function automate() {
        if(session()->has('unsaved.schedule')) {
            $this->saveSchedule();
        }

        $subjects = Subject::with('defaultSubject.subjectType')->get();
        $teachers = SubjectTeacher::with('teacher', 'subject')->get();
        $classrooms = Classroom::all();
        
        $subjectHours = array();

        foreach($classrooms as $classroom) {
            $subjectHours[$classroom->id] = array();
        }

        foreach($subjectHours as $key => $classroom) {
            
            
            foreach($subjects as $subject) {
                $subjectHours[$key][$subject->id] = ['sp' => $subject->sp_frequency, 'dp' => $subject->dp_frequency];
            }
        }

        $classSchedules = ClassSchedule::where('school_year_id', 1)->get();

        dd($subjectHours[1]);
    }

    public function saveSchedule() {
        $classrooms = session()->pull('unsaved.schedule');

        foreach($classrooms as $classroomId => $classroom) {
            foreach($classroom as $schedule) {
                ClassSchedule::where('classroom_id', $classroomId)
                ->where('timetable', $schedule->timetable)
                ->where('period_slot', $schedule->period_slot)
                ->where('day_id', $schedule->day_id)
                ->update([
                    'subject_teacher_id' => $schedule->subject_teacher_id == '' ? null : $schedule->subject_teacher_id
                ]);
            }    
        }
    }
}
