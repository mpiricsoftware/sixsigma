<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subplan_id',
        'user_limit',
        'site_limit',
        'company_limit',
        'start_date',
        'renew_date',
        'expiry_date'
    ];
}
