<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = ['name', 'label'];

    public const SUPER_ADMIN = 'super_admin';

    public const ADMIN = 'admin';

    public const STAFF = 'staff';

    public const TELLER = 'teller';

    public const STUDENT = 'student';

    // create the function(undefinded here) to call in the dbseeder

    public static function getIdByName(string $name): ?int
    {
        return static::where('name', $name)->value('id');
    }

    public static function getIdByNameOrFail(string $name): int
    {
        $record = static::where('name', $name)->first();

        if (! $record) {
            throw new \Exception("Name [$name] not found in ".static::class);
        }

        return $record->id;
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // Get users with this role
    public function getUsersWithThisRole()
    {
        return $this->users();
    }

    // Check if this is the super_admin role
    public function isSuperAdmin(): bool
    {
        return $this->name === self::SUPER_ADMIN;
    }

    // Get the super_admin user (if this is the super_admin role)
    public function getSuperAdminUser(): ?User
    {
        if ($this->isSuperAdmin()) {
            return $this->users()->first();
        }
        return null;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }
}
