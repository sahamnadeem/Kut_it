<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = ['title','price','status'];

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function booking(){
        return $this->belongsToMany(Booking::class,'orders','service_id','booking_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
}
