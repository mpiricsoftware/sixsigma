<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'site_id',
        'comp_id'
    ];

    public function site() {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function company() {
        return $this->belongsTo(company::class, 'comp_id', 'id');
    }
}
