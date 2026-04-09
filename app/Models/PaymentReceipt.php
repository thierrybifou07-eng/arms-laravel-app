<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
    use Auditable;
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'amount',
        'number',
        'issue_date',
        'file_path',
    ];
}
