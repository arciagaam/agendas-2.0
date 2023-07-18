<?php

namespace App\Models;

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
}
