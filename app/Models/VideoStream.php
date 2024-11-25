<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'protocol',
        'username',
        'password',
        'camera_ip',
        'port'
    ];
}
