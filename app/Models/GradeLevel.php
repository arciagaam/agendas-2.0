<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradeLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'gr_level',
    ];

    public function scopeGetGradeLevelsOnly(Builder $query) {
        return $query
        ->whereNotIn('id', [11, 12])
        ->when(request()->search || request()->search != '', function ($query) {
            $query->where('name', 'like', request()->search . '%');
        })
        ->latest();
    }

    public function classrooms() : HasMany {
        return $this->hasMany(Classroom::class);
    }
}
