<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelHistory extends Model
{
    protected $fillable = ['user_id','res_name','date','in','out','establishment_id','establishment_name','establishment_address', 'role', 'id_number', 'cp_number', 'tel_number', 'address', 'emergency_contact', 'ec_cp_number', 'email'];

    public function establishment(){
        return $this->belongsTo(Establishment::class);
    }

    public function resident(){
        return $this->belongsTo(User::class);
    }

    public function getFullAddress()
    {
    return "{$this->street} {$this->barangay} {$this->city}";
    }
}
