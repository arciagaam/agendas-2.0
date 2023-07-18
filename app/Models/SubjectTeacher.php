<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'subject_id'
    ];

    public function scopeGetTypes(Builder $query) {
        return $query
        ->join('subjects', 'subjects.id', 'subject_id')
        ->join('default_subjects', 'default_subjects.id', 'default_subject_id')
        ->where('default_subjects.subject_type_id', 2)
        ->orWhere('default_subjects.subject_type_id', 3)
        ->select(['subject_teachers.id', 'subjects.subject_name']);
    }

}