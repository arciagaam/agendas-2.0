<?php

namespace App\Http\Controllers\admin\schedules;

use DateTime;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\GradeLevel;
use Illuminate\Http\Request;
use App\Models\ClassSchedule;
use App\Models\SubjectTeacher;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Faker\Core\Number;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (!request()->grade_level_id && request()->classroom_id) {
            return redirect()->route('admin.schedules.classes.index');
        }

        return view('pages.admin.schedules.classes.index', [
            'gradeLevels' => GradeLevel::getGradeLevelsOnly()->latest()->get(),
            'sections' => Classroom::classScheduleClassrooms()->latest()->get(),
            'subjects' => Subject::getSubjectsByGradeLevel()->with([
                'defaultSubject',
                'subjectTeachers' => [
                    'teacher.user',
                    'teacher.honorific'
                ]
            ])->get(),
            'classSchedule' => session()->missing("unsaved.schedule." . request()->classroom_id) ? ClassSchedule::getClassSchedule()->get() : collect(session("unsaved.schedule." . request()->classroom_id)),
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

    public function storeSession()
    {
        $schedule = json_decode(request()->schedule);
        $classroomId = $schedule[0]->classroom_id;
        session(["unsaved.schedule.$classroomId" => $schedule]);
    }

    public function removeSession($classroomId)
    {
        session()->forget("unsaved.schedule.$classroomId");
    }

    public function save()
    {
        $this->saveSchedule();
        return response(['message' => 'Schedule successfully saved.', 200]);
    }

    public function automate()
    {
        if (session()->has('unsaved.schedule')) {
            $this->saveSchedule();
        }

        $subjects = Subject::with('defaultSubject.subjectType')->get();
        $teachers = SubjectTeacher::with('teacher', 'subject')->get();
        $classrooms = Classroom::all();

        $subjectHours = array();
        $teacherHours = array();

        //Putting values of sp, dp frequency to each subject
        foreach ($classrooms as $classroom) {
            $subjectHours[$classroom->id] = array();
        }
        //creating structure for subjectHours
        foreach ($classrooms as $classroom) {
            foreach ($subjects as $subject) {
                if ($classroom->grade_level_id == $subject->gr_level_id) {
                    $subjectHours[$classroom->id][$subject->id] = ['sp' => $subject->sp_frequency, 'dp' => $subject->dp_frequency];
                }
            }
        }

        //creating structure for teacherHours
        foreach ($teachers as $key => $teacher) {
            if (isset($teachers[$key]['teacher']['id']) && $teachers[$key]['teacher']['id'] !== null) {
                $uniqueTeacherId = $teachers[$key]['teacher']['id'];
                if (!isset($teacherHours[$uniqueTeacherId])) {
                    $teacherHours[$uniqueTeacherId] = array(
                        'max_hours' => array(),
                        'regular_load' => $teachers[$key]['teacher']['regular_load']
                    );
                }
            }
            //adding days under max_hours
            for ($i = 1; $i < 7; $i++) {
                if (isset($teachers[$key]['teacher']) && isset($teachers[$key]['teacher']['max_hours'])) {
                    $teacherHours[$uniqueTeacherId]['max_hours'][$i] = $teachers[$key]['teacher']['max_hours'];
                }
            }
        }


        $classSchedules = ClassSchedule::forAutomation()->where('school_year_id', 1)->get();

        $markedAsChecked = [];
        foreach ($classSchedules as $index => $schedule) {
            //di ko sure if kailangan to 
            // if ($schedule->subject_teacher_id == null) continue;

            //compute period duration
            $timeStart = DateTime::createFromFormat('H:i', $schedule->time_start);
            $timeEnd = DateTime::createFromFormat('H:i', $schedule->time_end);

            $duration = $timeStart->diff($timeEnd);
            $durationInSeconds = $duration->s + $duration->i * 60 + $duration->h * 3600;
            $durationInHours = $durationInSeconds / 3600;

            $teacherId = null;
            $subjectId = null;

            foreach($teachers as $key => $teacher) {
                if($schedule->subject_teacher_id == $teacher->id) {
                    if (isset($teachers[$key]['teacher'])) {
                        $teacherId = $teachers[$key]['teacher']['id'];
                        $subjectId = $teachers[$key]['subject']['id'];
                        break;
                    }
                }
            }

            //subtract teacher hours
            if ($teacherId !== null) {
                $teacherHours[$teacherId]['max_hours'][$schedule->day_id] -= $durationInHours;
                $teacherHours[$teacherId]['regular_load'] -= $durationInHours;
            }

            //subtract subject sp frequency
            if ($subjectId !== null) {
                if(in_array($schedule, $markedAsChecked)) {
                    continue;
                }

                // check for dp
                $dpCheck = $classSchedules->filter(function($filterCS) use ($schedule, $subjectId) {
                    return 
                    $schedule->classroom_id == $filterCS->classroom_id &&
                    $schedule->timetable == $filterCS->timetable &&
                    $schedule->day_id == $filterCS->day_id &&
                    $schedule->period_slot + 1 == $filterCS->period_slot &&
                    $subjectId == $filterCS->subject_id;
                });

                if(count($dpCheck)) {
                    $subjectHours[$schedule->classroom_id][$subjectId]['dp'] -= 1;
                    array_push($markedAsChecked, ...$dpCheck);
                }else {
                    $subjectHours[$schedule->classroom_id][$subjectId]['sp'] -= 1;
                }
            }
        }
        
        $updateSchedules = [];
        // automate
        foreach($classSchedules as $schedule) {
            if($schedule->subject_id != null) continue;
            $subjectTeachers = $teachers->filter(fn($st) => $st->subject->gr_level_id == $schedule->grade_level_id)->toArray();
            shuffle($subjectTeachers);
            

            foreach($subjectTeachers as $subjectTeacher) {
                $subjectTeacher = (object) $subjectTeacher;
                
                //check existing subject in same day
                $existingSubjectSameDay = $classSchedules->filter(function($cs) use($schedule, $subjectTeacher) {
                    return $cs->day_id == $schedule->day_id &&
                    $cs->subject_teacher_id == $subjectTeacher->id &&
                    $cs->period_slot != $schedule->period_slot;
                });

                if(count($existingSubjectSameDay)) {
                    continue;
                }

                // foreach($classSchedules as $cs) {
                //     if ($cs->classroom_id == $schedule->classroom_id) {
                //         if ($cs->subject_teacher_id == $subjectTeacher->id) {
                //                 foreach($subjectTeachers as $st) {
                //                 if ($st['subject_id'] == $subjectTeacher->subject_id && $st['teacher_id'] != $subjectTeacher->teacher_id) {
                //                     continue;
                //                 }
                //             }
                //         }
                //     }
                // }

                // check teacher conflict
                $checkTeacherConflict = $classSchedules->filter(function($cs) use($schedule, $subjectTeacher) {
                    $scheduleTimeStart = Carbon::parse($cs->time_start);
                    $scheduleTimeEnd = Carbon::parse($cs->time_end);
                    
                    $cellDataTimeStart = Carbon::parse($schedule->time_start);
                    $cellDataTimeEnd = Carbon::parse($schedule->time_end);
                    
                    // if($cs->teacher_id == $subjectTeacher->teacher_id){
                    //     dd($cs->teacher_id == $subjectTeacher->teacher_id);
                    // }
                    
                    return 
                    $cs->day_id == $schedule->day_id &&
                    $cs->teacher_id == $subjectTeacher->teacher_id &&
                    $cs->period_slot == $schedule->period_slot &&
                    (
                    ($cellDataTimeStart->isAfter($scheduleTimeStart) && $cellDataTimeStart->isBefore($scheduleTimeEnd)) ||
                    ($cellDataTimeEnd->isAfter($scheduleTimeStart) && $cellDataTimeEnd->isBefore($scheduleTimeEnd)) ||
                    ($cellDataTimeStart->isBefore($scheduleTimeStart) && $cellDataTimeEnd->isAfter($scheduleTimeEnd)) ||
                    $cellDataTimeStart->isSameAs($scheduleTimeStart) ||
                    $cellDataTimeEnd->isSameAs($scheduleTimeEnd)
                    );
                });
                
                if(count($checkTeacherConflict)) {
                    continue;
                }

                //check sp
                if($subjectHours[$schedule->classroom_id][$subjectTeacher->subject_id]['sp'] > 0) {
                    array_push($updateSchedules, ['id' => $schedule->class_schedule_id, 'subject_teacher_id' => $subjectTeacher->id]);
                    $schedule['subject_teacher_id'] = $subjectTeacher->id;
                    $schedule['teacher_id'] = $subjectTeacher->teacher_id;
                    $schedule['subject_id'] = $subjectTeacher->subject_id;

                    $subjectHours[$schedule->classroom_id][$subjectTeacher->subject_id]['sp'] -= 1;
                    break;
                }

                //check dp

            }
            // dd($subjects);


            // dd($subjectTeachers);
        }

        foreach($updateSchedules as $updateSchedule) {
            ClassSchedule::where('id', $updateSchedule['id'])->update($updateSchedule);
        }

        return back();
    }

    public function saveSchedule()
    {
        $classrooms = session()->pull('unsaved.schedule');

        foreach ($classrooms as $classroomId => $classroom) {
            foreach ($classroom as $schedule) {
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
