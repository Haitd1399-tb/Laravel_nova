<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;


    public function drugs()
    {
        return $this->belongsToMany(Drug::class)
                    ->withPivot('note')
                    ->withTimestamps();                 
    }

    public function days()
    {
        return $this->belongsToMany(Day::class)
                    ->withPivot('price')
                    ->withTimestamps();
    }

    public function prescriptions() {
        return $this->hasMany(Prescription::class);
    }
}
