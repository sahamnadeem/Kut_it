<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    use SoftDeletes;
    public function roles(){
        return $this->belongsToMany(Role::class );
    }
    public function users(){
        return $this->belongsToMany(User::class );
    }
    public function status(){
        return $this->belongsTo(Status::class,'status_id');
    }

}
