<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthDeclaration extends Model
{
    protected $fillable = ['est_id','user_id', 'temp','q1','q2','fever','cough','runny_nose','sore_throat','shortness_of_breath'];
}
