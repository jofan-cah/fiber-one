<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortOdps extends Model
{
    use HasFactory;

    protected $fillable = [
        'odp_id',
        'port_number', // Nomor port yang unik untuk ODP ini
        'subs_id', // Status apakah port ini tersedia atau tidak
    ];

    public function odp()
    {
        return $this->belongsTo(Odp::class, 'odp_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'subs_id');
    }

}

