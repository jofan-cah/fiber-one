<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $fillable = ['olt_id', 'odc_id', 'odp_id', 'port_number', 'status','directions'];

    public function olt()
    {
        return $this->belongsTo(Olt::class, 'olt_id');
    }

    public function odc()
    {
        return $this->belongsTo(Odc::class, 'odc_id');
    }

    public function odp()
    {
        return $this->belongsTo(Odp::class, 'odp_id');
    }
}
