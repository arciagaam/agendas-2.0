<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id',
        'subject_teacher_id',
        'school_year_id',
        'timetable',
        'day_id',
        'period_slot',
        'time_start',
        'time_end',
    ];

    public function scopeGetClassSchedule(Builder $query) {
        $query->when(request()->classroom_id, function($classroomQuery) {
            $classroomQuery->where('classroom_id', request()->classroom_id);
        })
        ->join('subject_teachers', 'subject_teachers.id', 'class_schedules.subject_teacher_id')
        ->join('subjects', 'subjects.id', 'subject_teachers.subject_id')
        ->join('default_subjects', 'default_subjects.id', 'subjects.default_subject_id')
        ->leftjoin('teachers', 'teachers.id', 'subject_teachers.teacher_id')
        ->leftjoin('honorifics', 'honorifics.id', 'teachers.honorific_id')
        ->leftjoin('users', 'users.id', 'teachers.user_id')
        ->orderBy('timetable')
        ->orderBy('day_id')
        ->orderBy('period_slot')
        ->select([
            'class_schedules.id as class_schedule_id',
            'class_schedules.classroom_id as classroom_id',
            'class_schedules.subject_teacher_id as subject_teacher_id',
            'class_schedules.school_year_id as school_year_id',
            'class_schedules.timetable as timetable',
            'class_schedules.day_id as day_id',
            'class_schedules.period_slot as period_slot',
            'class_schedules.time_start as time_start',
            'class_schedules.time_end as time_end',
            'subjects.id as subject_id',
            'subjects.subject_name as subject_name',
            'default_subjects.id as default_subject_id',
            'default_subjects.subject_type_id as subject_type_id',
            'teachers.id as teacher_id',
            'honorifics.honorific as honorific',
            'users.first_name as first_name',
            'users.last_name as last_name',
        ]);
    }
}
