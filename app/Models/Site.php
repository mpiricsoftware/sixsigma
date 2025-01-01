<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'comp_id'
    ];

    public function company() {
        return $this->belongsTo(company::class, 'comp_id', 'id');
    }
}
