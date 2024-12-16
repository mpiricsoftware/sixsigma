<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class answer extends Model
{
    protected $table = 'answer';
    protected $fillable = [
      'user_id',
      'form_id',
    ];
    public function user()
    {
      return $this->belongsTo(User::class, 'id');
    }
    public function form()
    {
      return $this->belongsTo(form::class, 'id');
    }
}
