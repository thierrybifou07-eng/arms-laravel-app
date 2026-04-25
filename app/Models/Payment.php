<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;


class Payment extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected static function booted(): void
    {
        $syncContractAmounts = function (Payment $payment): void {
            collect([
                $payment->contract_id,
                $payment->getOriginal('contract_id'),
            ])
                ->filter()
                ->unique()
                ->each(function (int $contractId): void {
                    Contract::query()->find($contractId)?->syncContractAmount();
                });
        };

        static::saved($syncContractAmounts);
        static::deleted($syncContractAmounts);
    }

    protected $fillable = [
        'contract_id',
        'payment_method_id',
        'payment_status_id',
        'expected_amount',
        'paid_amount',
        'tip_amount',
        'payment_date',
        'due_date',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'due_date' => 'date',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function status()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function isOverdue(): bool
    {

        return $this->due_date
            && $this->paid_amount < $this->expected_amount
            && now()->gt($this->due_date)
            && $this->status?->code !== 'validated'
            && $this->status?->code !== 'cancelled';
    }

    public function scopeForManager(Builder $query, User $user): Builder
    {
        if (! $user->isResidenceScoped()) {
            return $query;
        }

        return $query->whereHas('contract.room.floor.building.residence.users', fn (Builder $builder) => $builder->whereKey($user->id));
    }
}
