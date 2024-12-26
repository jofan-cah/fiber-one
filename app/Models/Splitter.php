<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Splitter extends Model
{
    use HasFactory;

    protected $fillable = ['odc_id', 'port_start', 'port_end', 'odp_id', 'port_number', 'direction'];

    public function odc()
    {
        return $this->belongsTo(Odc::class, 'odc_id');
    }

    public function odp()
    {
        return $this->belongsTo(Odp::class, 'odp_id');
    }
}

