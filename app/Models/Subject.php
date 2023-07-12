<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        ->when(request()->search || request()->search != '', function ($query) {
            $query->where('name', 'like', request()->search . '%');
        })
        ->latest()
        ->paginate(request()->rows ?? 10)
        ->appends(request()->query());
    }
    
    public function prioritizedSubjects() {
        return $this->hasOne(PrioritizedSubjects::class);
    }
}
