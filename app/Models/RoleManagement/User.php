<?php

namespace App\Models\RoleManagement;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table      = 'user';
    protected $primaryKey = 'user_id';
    protected $guarded    = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * Get user role record associated with the user.
     */
    public function userRole()
    {
        return $this->hasOne(UserRole::class, 'user_id', 'user_id');
    }

    /**
     * Get role record associated with the user.
     */
    public function role()
    {
        return $this->hasOneThrough(
        	Role::class,
            UserRole::class,
            'user_id', // Foreign key on user_role table...
            'role_id', // Foreign key on role table...
            'user_id', // Local key on user table...
            'role_id' // Local key on user_role table...
        );
    }

}
