<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class answer extends Model
{
    protected $table = 'answer';
    protected $fillable = [
      'user_id',
      'question_id',
      'section_id',
      'answer'
    ];
    public function user()
    {
      return $this->belongsTo(User::class, 'id');
    }
    public function question()
    {
      return $this->belongsTo(Question::class, 'id');
    }
    public function section()
    {
      return $this->belongsTo(section::class, 'id');
    }
}
