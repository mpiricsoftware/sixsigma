<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
class User extends Authenticatable implements MustVerifyEmail

{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'subgroup_id',
        'subplan_id',
        'password',
        'usertype',
        'company_id',
        'site_id',
        'department_id',
        'status',
        'mobileno',
        'company',
        'address',
        'country',
        'state',
        'city',
        'office_no',
        'lastname',
        'username',
        'google_id',
        'email_verified_at',
        'designation',
        'company_size'


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function company()
    {
        return $this->belongsTo(company::class, 'company_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'id');
    }


    // public function save(array $options = [])
    // {
    //     if ($this->isDirty('status')) {
    //         parent::save($options);
    //         Mail::to($this->email)->send(new UserApproved($this));
    //     } else {
    //         parent::save($options); // Just save without sending email
    //     }
    // }


}
