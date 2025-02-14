<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pillar extends Model
{
   protected $table = 'pillar';
    protected $fillable = [
      'user_id',
      'form_id',
      'name',
      'description'
    ];

    public function form()
    {
      return $this->belongsTo(form::class, 'id');
    }

    public function user()
    {
      return $this->belongsTo(user::class ,'id');
    }
}
