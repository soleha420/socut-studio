<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function user()
{
        return $this->belongsTo(User::class);
}

    public function service()
{
        return $this->belongsTo(Service::class);
}

    public function stylist()
{
        return $this->belongsTo(Stylist::class);
}
}
