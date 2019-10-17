<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    protected $fillable=['user_id','lat','lng'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
