<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'student_id',
        'room_id',
        'contract_status_id',
        'billing_period_id',
        'rent_amount',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // relationship with student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // relationship with room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function status()
    {
        return $this->belongsTo(ContractStatus::class, 'contract_status_id');
    }

    public function billingPeriod()
    {
        return $this->belongsTo(BillingPeriod::class, 'billing_period_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // bussiness logic to check overlapping contracts for the same room
    public static function hasOverlap($roomId, $start, $end, $ignoreId = null)
    {
        $pendingId = ContractStatus::where('code', 'pending')->value('id');
        $activeId = ContractStatus::where('code', 'active')->value('id');
        $query = self::where('room_id', $roomId)->whereIn('contract_status_id', [$pendingId, $activeId])
            ->where(function ($q) use ($start, $end) {
                $q->where('start_date', '<=', $end)->where('end_date', '>=', $start);
            });
        // Ignore the current contract when checking for overlaps during update

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }

    /*     Function to check the overdue to apply panalty to the resident
     */
    public function checkOverdue()
    {
        $hasOverdue = $this->payments()
            ->where('due_date', '<', now())
            ->whereColumn('paid_amount', '<', 'expected_amount')
            ->exists();

        /*  if ($hasOverdue) { */
        if ($hasOverdue && ! in_array($this->status->code, ['expired', 'terminated'])) {
            $overdueId = ContractStatus::where('code', 'overdue')->value('id');

            $this->update([
                'contract_status_id' => $overdueId,
            ]);
        }
    }

    /*     if the status is expired
     */
    public function checkExpired()
    {
        /*  if ($this->end_date < now()) { */
        if ($this->end_date < now() && $this->status->code !== 'terminated') {
            $expiredId = ContractStatus::where('code', 'expired')->value('id');

            $this->update([
                'contract_status_id' => $expiredId,
            ]);
        }
    }
}
