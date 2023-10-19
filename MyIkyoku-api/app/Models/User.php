<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    public const USER_ROLE_MEMBER = 'member';
    public const USER_ROLE_ADMIN = 'admin';

    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role($role) {
        $role = (array)$role;
        return in_array($this->role, $role);
    }

    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }

}
