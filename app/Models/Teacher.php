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
        ->join('users', 'users.id', 'user_id')
        ->when(request()->search || request()->search != '', function ($query) {
            $query->where('name', 'like', request()->search . '%');
        })
        ->latest('teachers.created_at')
        ->paginate(request()->rows ?? 10)
        ->appends(request()->query());
    }

}
