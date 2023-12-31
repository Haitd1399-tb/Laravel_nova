<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    public function patients()
    {
        return $this->belongsToMany(Patient::class)
                    ->withPivot(['note', 'price'])
                    ->withTimestamps();
    }
}
