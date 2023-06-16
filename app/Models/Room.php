<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'building_id'
    ];

    public function scopeGetRooms(Builder $query) {
        return $query
        ->join('buildings', 'buildings.id', 'rooms.building_id')
        ->when(request()->search || request()->search != '', function ($query) {
            $query->where('rooms.name', 'like', request()->search . '%');
        })
        ->latest('rooms.created_at')
        ->select(['rooms.*', 'buildings.name as building'])
        ->paginate(request()->rows ?? 10)
        ->appends(request()->query());
    }

    public function building() : BelongsTo {
        return $this->BelongsTo(Building::class);
    }
}
