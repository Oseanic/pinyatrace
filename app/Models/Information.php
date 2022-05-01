<?php

namespace App\Models;

use App\Models\Establishment;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $fillable = ['est_id','company_name', 'acronym', 'cp_number','tel_number','company_address', 'health_dec_status'];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'est_id');
    }
}
