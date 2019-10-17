<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable=['booking_id','edited','review','user_id','rating_id'];
    public function rating(){
        return $this->belongsTo(Rating::class,'rating_id');
    }
}
