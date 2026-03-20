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
        'start_date'=>'date',
        'end_date'=>'date',
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
    //bussiness logic to check overlapping contracts for the same room
    public static function hasOverlap($roomId, $start, $end)
    {
        $pendingId=ContractStatus::where('code','pending')->value('id');
        $activeId=ContractStatus::where('code','active')->value('id');
        return self::where('room_id', $roomId)->whereIn('contract_status_id',[$pendingId,$activeId])
        ->where(function($query) use ($start, $end) {
            $query->where('start_date','<=',$end)->where('end_date','>=',$start);
    })->exists;
    }
}
