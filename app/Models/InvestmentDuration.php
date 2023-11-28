<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentDuration extends Model
{
    use HasFactory;

    protected $table = 'investment_durations';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
