<?php

namespace App\Models;

use App\Models\Information;
use App\Models\Representative;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Establishment extends Authenticatable
{
    use Notifiable;

    protected $guard = 'establishment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *Establishment
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function information()
    {
        return $this->hasOne(Information::class, 'est_id');
    }

    public function representative()
    {
        return $this->hasOne(Representative::class, 'est_id');
    }

    public function travelHistory(){
        return $this->hasMany(TravelHistory::class);
    }
    
}
