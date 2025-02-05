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
      'pillar_id'
    ];
    public function form()
    {
      return $this->belongsTo(form::class, 'id');
    }
    public function question()
    {
        return $this->hasMany(Question::class, 'section_id');
    }
    public function pillar()
    {
      return $this->belongsTo(pillar::class, 'pillar_id');
    }

}
