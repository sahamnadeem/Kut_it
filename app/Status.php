<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

    protected $fillable = ['title','classname'];

    public function users(){
        return $this->hasMany(User::class,'status_id');
    }
    public function projects(){
        return $this->hasMany(Project::class);
    }
    public function permissions(){
        return $this->hasMany(Permission::class);
    }
}
