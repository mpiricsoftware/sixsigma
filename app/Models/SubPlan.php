<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\HashTable;

class SubPlan extends Model
{
    use HasFactory;

    protected $table = 'subplans';

    protected $fillable = [
        'subgroup_id',
        'name',
        'price',
        'option',
        'user_limit',
        'site_limit',
        'company_limit',
        'features',
        'description'
    ];

    public function subgroup()
    {
        return $this->belongsTo(Subgroup::class, 'subgroup_id');
    }

    public function subscription()
    {
        return $this->belongsTo(subscription::class, 'subscription_id');
    }
}

