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

    // Relasi ke ODC
    public function odcs()
    {
        return $this->hasMany(Odc::class, 'olt_id');
    }

    // Relasi langsung ke ODP
    public function odps()
    {
        return $this->hasMany(Odp::class, 'olt_id');
    }

    // Mendapatkan semua ODP yang terhubung (baik langsung maupun melalui ODC)
    public function allOdps()
    {
        return Odp::whereIn('odc_id', $this->odcs->pluck('odc_id')->toArray())
            ->orWhere('olt_id', $this->olt_id);
    }

     // Relasi ke Port
     public function ports()
     {
         return $this->hasMany(Port::class, 'olt_id');
     }
}
