<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['user_id','res_name','date','in', 'role', 'id_number', 'cp_number', 'tel_number', 'address', 'emergency_contact', 'ec_cp_number', 'email', 'image'];
    
    public function resident(){
        return $this->belongsTo(User::class);
    }

    public function getFullAddress()
    {
    return "{$this->street} {$this->barangay} {$this->city}";
    }
}
