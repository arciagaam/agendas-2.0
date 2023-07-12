<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'honorific_id',
        'max_hours',
        'regular_load',
        'user_id',
        'is_available'
    ];

    public function scopeGetTeachers(Builder $query) {
        return $query
        ->join('honorifics', 'honorifics.id', 'honorific_id')
        ->join('users', 'users.id', 'teachers.user_id')
        ->when(request()->search || request()->search != '', function ($query) {
            $query->where('first_name', 'like', request()->search . '%');
        })
        ->select('teachers.*', 'teachers.id as teacher_id', 'honorifics.*', 'honorifics.id as honorific_id', 'users.*', 'users.id as user_id')
        ->latest('teachers.created_at')
        ->paginate(request()->rows ?? 10)
        ->appends(request()->query());
    }

    // public function scopeGetTeacher(Builder $query) {
    //     return $query
    //     ->join('honorifics', 'honorifics.id', 'honorific_id')
    //     ->join('users', 'users.id', 'teachers.user_id')
    //     ->select('teachers.*', 'teachers.id as teacher_id', 'honorifics.*', 'honorifics.id as honorific_id', 'users.*', 'users.id as user_id')
    //     ->where('teachers.id', request()->teacher->id)
    //     ->latest('teachers.created_at');
    // }

    public function adviser() {
        return $this->hasOne(Adviser::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
