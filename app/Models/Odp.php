<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odp extends Model
{
    use HasFactory;
    protected $table = 'odps';
    protected $primaryKey = 'odp_id';
    public $incrementing = false;
    protected $fillable = [
        'odp_id',
        'odc_id',
        'odp_name',
        'odp_description',
        'odp_location_maps',
        'odp_addres',
        'odp_port_capacity'
    ];

    public function odc()
    {
        return $this->belongsTo(Odc::class, 'odc_id');
    }

    public function subs()
    {
        return $this->hasMany(Subscription::class, 'odp_id');
    }
}
