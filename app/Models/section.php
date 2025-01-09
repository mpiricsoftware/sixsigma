<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    protected $table = 'section';
    protected $fillable = [
      'form_id',
      'section_name',
      'section_description',
    ];
    public function form()
    {
      return $this->belongsTo(form::class, 'id');
    }
    public function question()
    {
        return $this->hasMany(Question::class, 'section_id');
    }

}
