<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PrioritizedSubjects extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'subject_id',
        'classroom_id',
        'priority_time',
        'priority_day',
    ];

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
}
