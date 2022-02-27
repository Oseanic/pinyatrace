<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CovidCase extends Model
{
    protected $fillable = ['patient_id','name','address','email','number','status'];
}
