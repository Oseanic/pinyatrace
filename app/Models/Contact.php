<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['user_id','emergency_contact','relationship','ec_cp_number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
