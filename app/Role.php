<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    //
    use SoftDeletes;

    protected $table='roles';

    protected $fillable=['name','display_name','description'];

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function permissions(){
        return $this->belongsToMany(Permission::class );
    }
    public function created_by_user(){
        return $this->belongsTo(User::class,'created_by')->withDefault([
            'name' => 'Not Set'
        ]);
    }
}
