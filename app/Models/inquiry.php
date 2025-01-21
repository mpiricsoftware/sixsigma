<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inquiry extends Model
{
    protected $table = 'inquiry';
    protected $fillable  = [
      'user_id',
      'form_id',
      'name',
      'company',
      'designation',
      'date_time',
      'email',
      'Phone_no',
      'type',
      'form_name'
    ];

    public function user()
    {
      return $this->belongsTo(user::class, 'id');
    }
    public function form()
    {
      return $this->belongsTo(Form::class, 'id');
    }
}
