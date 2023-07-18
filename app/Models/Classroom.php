<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'grade_level_id',
        'section',
        'class_link',
    ];

    public function scopeGetClassrooms(Builder $query) {
        $query
        ->join('rooms', 'rooms.id', 'room_id')
        ->join('buildings', 'buildings.id', 'rooms.building_id')
        ->when(request()->search || request()->search != '', function ($query) {
            $query->where('classrooms.section', 'like', request()->search . '%');
        })
        ->when(request()->grade_level_id, function($query) {
            $query->where('classrooms.grade_level_id', request()->grade_level_id);
        })
        ->latest('classrooms.created_at')
        ->select(['classrooms.*', 'rooms.name as room', 'buildings.name as building'])
        ->paginate(request()->rows ?? 10)
        ->appends(request()->query());
    }

    public function scopeClassScheduleClassrooms(Builder $query) {
        // $query->when(request()->grade_level_id, function($query) {
            $query->where('classrooms.grade_level_id', request()->grade_level_id);
        // });
    }
}
