<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id','first_name','surname','middle_name','dob','age','sex','street','barangay','city','tel_number','cp_number', 'id_number', 'role'];

    public function getFullname(){
        return $this->first_name.' '.$this->middle_name.' '.$this->surname;
    }

    public function getFullAddress(){
        return $this->street.' '.$this->barangay.' '.$this->city;
    }


    public function address(){
        return $this->street.' '.'Brgy.'.$this->barangay.','.$this->city;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
