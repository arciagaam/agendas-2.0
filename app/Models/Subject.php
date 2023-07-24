<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_code',
        'subject_name',
        'subject_description',
        'default_subject_id',
        'gr_level_id',
        'sp_frequency',
        'dp_frequency',
    ];

    public function scopeGetSubjects(Builder $query) {
        return $query
        ->when(request()->gr_level_id != '', function ($query) {
            $query->where('gr_level_id', request()->gr_level_id);
        })
        ->when(request()->search || request()->search != '', function ($query) {
            $query->where('subject_name', 'like', request()->search . '%');
        })
        ->latest()
        ->paginate(request()->rows ?? 10)
        ->appends(request()->query());
    }

    public function scopeGetSubjectsByGradeLevel(Builder $query) {

        $subquery = SubjectTeacher::join('subjects', 'subjects.id', 'subject_teachers.subject_id')
        ->join('default_subjects', 'default_subjects.id', 'subjects.default_subject_id')
        ->where('subject_type_id', '!=', 1)
        ->select([
            'subject_teachers.id as subject_teacher_id',
            'subjects.default_subject_id as default_subject_id'
        ]);

        return $query->leftJoinSub($subquery, 't1', function(JoinClause $join) {
            $join->on('subjects.default_subject_id', 't1.default_subject_id');
        })
        ->where('gr_level_id', request()->grade_level_id)
        ->orWhere('gr_level_id', 11)
        ->select([
            'subjects.*',
            't1.subject_teacher_id as subject_teacher_id'
        ])
        ->latest('subjects.created_at');

    }
    
    public function prioritizedSubjects() : HasOne {
        return $this->hasOne(PrioritizedSubjects::class);
    }
    
    public function defaultSubject() : BelongsTo {
        return $this->belongsTo(DefaultSubject::class, 'default_subject_id');
    }
}
