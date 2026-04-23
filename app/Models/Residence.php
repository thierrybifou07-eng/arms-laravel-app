<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Residence extends Model implements AuditableContract
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected static function newFactory()
    {
        return \Database\Factories\ResidenceFactory::new();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'residence_status_id',
        'name',
        'city',
        'address',
        'capacity',
    ];

    // relationship with the manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Assign a status

    public function status()
    {
        return $this->belongsTo(ResidenceStatus::class, 'residence_status_id');
    }
    // relationship with buildings

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    // relationship with users
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeForManager(Builder $query, User $user): Builder
    {
        if (! $user->isResidenceScoped()) {
            return $query;
        }

        return $query->whereHas('users', fn (Builder $builder) => $builder->whereKey($user->id));
    }
}
