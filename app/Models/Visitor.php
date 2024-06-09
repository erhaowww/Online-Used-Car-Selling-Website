<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'device',
        'os',
        'ip_address',
        'current_location',
        'visit_time',
        'browser'
    ];
}
