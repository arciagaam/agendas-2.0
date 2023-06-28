<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PrioritizedSubjects extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'classroom_id',
        'priority_time',
        'priority_day',
    ];

    
}
