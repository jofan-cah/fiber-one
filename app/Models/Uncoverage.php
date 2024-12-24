<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uncoverage extends Model
{
    use HasFactory;

    protected $table = 'uncoverage';

    protected $primaryKey = 'subs_id_uncover';

    protected $fillable = [
        'subs_id_uncover',
        'nama_subs',
        'no_hp',
        'maps_locations',
    ];
}
