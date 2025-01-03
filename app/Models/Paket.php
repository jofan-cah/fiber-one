<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{

    use HasFactory;

    protected $table = 'pakets';
    protected $primaryKey = 'pakets_id'; // Primary key sebagai string
    public $incrementing = false; // Non-incrementing ID
    protected $keyType = 'string'; // Tipe data untuk primary key

    protected $fillable = [
        'pakets_id',
        'nama_paket',
        'description',
        'price',
        'speed',
        'status',
        'discount',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'pakets_id');
    }
}
