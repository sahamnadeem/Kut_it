<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable=['uid','user_id','barber_id','total','user_location','booking_status_id','canceled_by','paid','balance'];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function barber(){
        return $this->belongsTo(User::class,'barber_id');
    }
    public function location(){
        return $this->belongsTo(BookingLocation::class,'user_location');
    }
    public function details(){
        return $this->belongsToMany(Service::class,'orders','booking_id','service_id')->withTimestamps();
    }
    public function status(){
        return $this->belongsTo(BookingStatus::class,'booking_status_id');
    }
    public function canceled_by_user(){
        return $this->belongsTo(User::class,'canceled_by');
    }
    public function ratings(){
        return $this->hasOne(Rating::class,'booking_id');
    }
    public function ratings_with_reviews(){
        return $this->hasOne(Rating::class,'booking_id')->with('reviews');
    }
    public function reviews_through(){
        return $this->hasManyThrough(Review::class, Rating::class,'booking_id');
    }
    
    public function services(){
        return $this->belongsToMany(Service::class,'orders','booking_id','service_id')->withTimestamps();
    }
}
