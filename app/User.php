<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;
use phpDocumentor\Reflection\Location;

class User extends Authenticatable
{
    use LaratrustUserTrait, HasApiTokens;
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','age', 'password','phone_no','deleted_at','status_id','barber_verified_at','activation_token','is_barber','android_token','ios_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'android_token', 'ios_token','otp','activation_token'
    ];

    protected $dates = ['deleted_at'];
    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function status(){
        return $this->belongsTo(Status::class)->withDefault([
            'title' => 'Not Set'
        ]);
    }
    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }
    public function services(){
        return $this->belongsToMany(Service::class)->withTimestamps();
    }
    public function services_main(){
        return $this->hasMany(Service::class, 'created_by');
    }
    public function barber_services(){
        return $this->hasMany(BarberService::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class,'user_id','id');
    }
    public function orders(){
        return $this->hasMany(Booking::class,'barber_id','id');
    }
    public function booking_cancle(){
        return $this->hasMany(Booking::class);
    }

    public function notifications(){
        return $this->belongsToMany(Booking::class,'notifications','user_id','logged_by');
    }
    public function notify_from(){
        return $this->belongsToMany(Booking::class,'notifications','logged_by','user_id');
    }
    public function location(){
        return $this->hasOne(UserLocation::class);
    }

    public function routeNotificationForFcm($notification)
    {
        return $this->android_token;
    }

    public function barber_rating()
    {
        return $this->hasManyThrough(Rating::class, Booking::class, 'barber_id', 'booking_id', 'id', 'id');
    }
    public function barber_reviews()
    {
        return $this->hasManyThrough(Review::class, Booking::class, 'barber_id', 'booking_id', 'id', 'id');
    }
    public function user_rating(){
        return $this->hasMany(Rating::class,'user_id');
    }
    public function user_ratingwith_reviews(){
        return $this->hasMany(Rating::class,'user_id')->with('reviews');
    }
    public function user_reviews(){
        return $this->hasMany(Review::class,'user_id');
    }

    public function balance(){
        return $this->hasOne(Balance::class,'user_id');
    }
}
