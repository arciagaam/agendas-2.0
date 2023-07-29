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


        $classSchedules = ClassSchedule::where('school_year_id', 1)->get();

        foreach ($classSchedules as $schedule) {
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
                $subjectHours[$schedule->classroom_id][$subjectId]['sp'] -= $durationInHours;
            }
        }

    }
    
    //shuffle function from agendas 1.0 
    public function shuffleArray(&$array)
    {
        $currentIndex = count($array);
        while ($currentIndex !== 0) {
            // Pick a remaining element.
            $randomIndex = mt_rand(0, $currentIndex - 1);
            $currentIndex--;

            // And swap it with the current element.
            [$array[$currentIndex], $array[$randomIndex]] = [$array[$randomIndex], $array[$currentIndex]];
        }

        return $array;
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
