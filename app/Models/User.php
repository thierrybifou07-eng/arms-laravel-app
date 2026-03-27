<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use InteractsWithMedia;

    public function avatar()
    {
        return $this->getFirstMediaUrl('avatars') ?:
        asset('images/default-avatar.png');
    }

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

  
// Assigning role to many users
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
// create the hasRole method for the middleware 
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
// create the hasPermission method for the middleware
    public function hasPermission(string $permissionName): bool
    {
        if ($this->hasRole(Role::SUPER_ADMIN)) {
            return true;
        }

        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permissionName) {
                $query->where('name', $permissionName);
            })->exists();
    }
}
