<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
        'user_status_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
    //  belongs to 'cause the fk is in the users table
    public function userStatus()
    {
        return $this->belongsTo(\App\Models\UserStatus::class);
    }
    // create the hasRole method for the middleware
    public function hasRole(string $roleName):bool
    {
        return $this->roles()->where('name',$roleName)->exists();
    }
    // Assign hasPermission method for the middleware
    public function hasPermission(string $permission):bool
    {
        return $this->roles()->whereHas('permission',function ($query) use 
        ($permission){
            $query->where('name',$permission);

        })->exists();
    }
}
