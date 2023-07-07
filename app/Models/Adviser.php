<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Adviser extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'classroom_id',
    ];

    public function scopeGetAdvisers(Builder $query) {
        return $query
        ->join('teachers', 'teachers.id', 'teacher_id')
        ->join('honorifics', 'honorifics.id', 'honorific_id')
        ->join('users', 'users.id', 'user_id')
        ->select('advisers.id AS adviser_id', 'teachers.*', 'honorifics.*', 'users.*')
        ->when(request()->search || request()->search != '', function ($query) {
            $query->where('first_name', 'like', request()->search . '%');
        })
        ->latest('teachers.created_at');
    }
        
    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
}
