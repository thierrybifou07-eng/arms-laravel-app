<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PaymentReceipt extends Model
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'amount',
        'number',
        'issue_date',
        'file_path',
    ];
}
