<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Olt extends Model
{
    use HasFactory;
    protected $table = 'olts';
    protected $primaryKey = 'olt_id';
    public $incrementing = false;
    protected $fillable = [
        'olt_id',
        'olt_name',
        'olt_description',
        'olt_location_maps',
        'olt_addres',
        'olt_port_capacity'
    ];

    public function odcs()
    {
        return $this->hasMany(Odc::class, 'olt_id');
    }
}
