<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class form extends Model
{
  protected $table = 'form';
  protected $fillable =
    [
       'user_id',
       'input_id',
       'name',
       'description',
       'slug'
    ];
    public function user()
    {
      return $this->belongsTo(User::class, 'id');
    }
    public function input()
    {
      return $this->belongsTo(Input::class, 'id');
    }
}
