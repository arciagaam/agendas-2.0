<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GradeLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'gr_level',
    ];

    // public function scopeGetDefaultSubjects(Builder $query) {
    //     return $query
    //     ->when(request()->search || request()->search != '', function ($query) {
    //         $query->where('name', 'like', request()->search . '%');
    //     })
    //     ->latest()
    //     ->paginate(request()->rows ?? 10)
    //     ->appends(request()->query());
    // }

}