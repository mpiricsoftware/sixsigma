<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Input extends Model
{
    use HasFactory;
    protected $table = 'input';
    protected $fillable = [
      'name',
      'icon',
      'type',
      'html_code',
    ];
}
