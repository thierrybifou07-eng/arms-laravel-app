<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'contract_id',
        'payment_method_id',
        'payment_status_id',
        'expected_amount',
        'paid_amount',
        'payment_date',
        'due_date',
    ];
    protected $casts=[
        'payment_date'=> 'date',
        'due_date'=> 'date',
    ];
    public function contract(){
        return $this->belongsTo(Contract::class);
    }
    public function status(){
        return $this->belongsTo(PaymentStatus::class,'payment_status_id');
    }
    public function method(){
        return $this->belongsTo(PaymentMethod::class,'payment_method_id');
    }
    public function isOverdue(): bool {

    return $this->due_date
        && $this->paid_amount < $this->expected_amount
        && now()->gt($this->due_date)
        && $this->status?->code !== 'validated'
        && $this->status?->code !== 'cancelled';
    } 
}
