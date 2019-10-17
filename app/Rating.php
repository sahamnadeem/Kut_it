<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable=['booking_id','edited','rating','user_id'];
    public function reviews(){
        return $this->hasOne(Review::class,'rating_id');
    }
    public function booking(){
        return $this->belongsTo(Rating::class,'booking_id');
    }

}
