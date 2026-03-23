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

    public static function getIdByName(string $name): int
    {
        return static::where('name', $name)->value('id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
