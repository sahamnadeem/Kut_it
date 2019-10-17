<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingLocation extends Model
{
    public function bookings(){
        return $this->belongsTo(Booking::class,'user_location');
    }
}
