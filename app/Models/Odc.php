<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odc extends Model
{
    use HasFactory;
    protected $table = 'odcs';
    protected $primaryKey = 'odc_id';
    public $incrementing = false;
    protected $fillable = [
        'odc_id',
        'olt_id',
        'odc_name',
        'odc_description',
        'odc_location_maps',
        'odc_addres',
        'odc_port_capacity'
    ];
    public function olt()
    {
        return $this->belongsTo(Olt::class, 'olt_id');
    }

    public function odps()
    {
        return $this->hasMany(Odp::class, 'odc_id');
    }
}
