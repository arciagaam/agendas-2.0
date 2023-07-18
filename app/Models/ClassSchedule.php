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
        ->orderBy('timetable')
        ->orderBy('day_id')
        ->orderBy('period_slot');
    }
}
