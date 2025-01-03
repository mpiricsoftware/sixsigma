<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inquiry extends Model
{
    protected $table = 'inquiry';
    protected $fillable  = [
      'user_id',
      'date_time',
      'email',
      'Phone_no'
    ];

    public function user()
    {
      return $this->belongsTo(user::class, 'id');
    }
}
