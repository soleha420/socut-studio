<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stylist extends Model
{
    protected $fillable = [
        'name',
        'specialist',
        'gender',
        'photo',
        'description',
    ];

    public function appointments()
    {
    return $this->hasMany(Appointment::class);
    }
}