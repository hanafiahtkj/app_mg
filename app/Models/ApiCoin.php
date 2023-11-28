<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiCoin extends Model
{
    use HasFactory;

    protected $table = 'api_coins';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'json' => 'array',
    ];
}
