<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    use HasFactory;

    protected $table = 'user_levels';
    protected $primaryKey = 'user_level_id';
    public $incrementing = false;
    protected $fillable = [
        'user_level_id',
        'user_name',
        'user_description',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_level_id');
    }
}
