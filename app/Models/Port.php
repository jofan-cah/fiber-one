<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $table = 'ports';

    protected $fillable = [
        'odp_id', 'port_number', 'status',
    ];

    public function odp()
    {
        return $this->belongsTo(Odp::class, 'odp_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'port');
    }
}
