<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    protected $fillable = [
    'section_id',
    'form_id',
    'question_text',
    'question_description',
    'type',
    'options'
    ];
    public function form()
    {
      return $this->belongsTo(form::class,'id');
    }
    public function section()
    {
      return $this->belongsTo(section::class,'id');
    }
    public function answer()
    {
      return $this->belongsTo(answer::class, 'id');
    }

}
