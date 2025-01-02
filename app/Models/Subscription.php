<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';
    protected $primaryKey = 'subs_id';
    public $incrementing = false;

    protected $fillable = [
        'subs_id',
        'subs_name',
        'subs_location_maps',
        'odp_id',
        'port',
        'sn',
        'type_modem',
    ];

    public function odp()
    {
        return $this->belongsTo(Odp::class, 'odp_id');
    }
    public function port()
    {
        return $this->belongsTo(Port::class, 'port');
    }
}
