<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
{
    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
