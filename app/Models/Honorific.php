<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Honorific extends Model
{
    use HasFactory;

    protected $fillable = [
        'honorific',
    ];

    public function scopeGetHonorific(Builder $query) {
        return $query
        ->where('id', request()->teacher->honorific_id)
        ->latest();
    }
}