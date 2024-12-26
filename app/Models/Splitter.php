<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Splitter extends Model
{
    use HasFactory;

    protected $table = 'splitters';

    protected $fillable = [
        'odc_id', 'type', 'port_count',
    ];

    public function odc()
    {
        return $this->belongsTo(Odc::class, 'odc_id');
    }

    // Relasi ke ODP berdasarkan splitter (misalnya mengarah ke ODP yang dibagi)
    public function odps()
    {
        return $this->hasMany(Odp::class);
    }
}
