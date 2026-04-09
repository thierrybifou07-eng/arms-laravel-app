<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use Auditable;

    //
    protected $fillable = ['name', 'label'];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
