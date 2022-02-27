<?php

namespace App\Models;

use App\Models\Establishment;
use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    protected $fillable = ['est_id','name','number','address','email','position'];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'est_id');
    }

}
