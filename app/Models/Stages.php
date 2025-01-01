<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stages extends Model
{
    protected $table = 'stages';
    protected $fillable = [
        'name',
        'form_id',
        'question_id',
        'answer_id',
    ];
    public function form(){
      return $this->belongsTo(form::class, 'id');
    }
}
