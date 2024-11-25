<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'email',
        'phone',
        'logo',
        'gst',
        'cin_no',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_country',
        'billing_zipcode',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'billing_country', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'billing_state', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'billing_city', 'id');
    }
}

