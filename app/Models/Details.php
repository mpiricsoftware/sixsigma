<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    protected $fillable = [
      'user_id',
      'form_id',
      'submission_id',
      'comment',
      'name',
      'lastname',
      'company',
      'date_time',
      'email',
      'Phone_no',
      'company_size',
      'form_name',
      'drivers',
      'business_goals',
      'Primary',
      'consultant',
      'located',
      'designation',
      'date',
      'tools'
    ];

    public function user()
    {
      return $this->belongsTo(User::class , 'id');
    }
    public function form()
    {
      return $this->belongsTo(form::class, '\id');
    }
}
