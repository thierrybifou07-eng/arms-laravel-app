<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\PaymentStatus;
use Illuminate\Console\Command;

class CheckOverduePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-overdue-payments'; 

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueId = PaymentStatus::where('code', 'overdue')->value('id');

        Payment::whereNotIn('payment_status_id', [
            PaymentStatus::where('code', 'validated')->value('id'),
            PaymentStatus::where('code', 'cancelled')->value('id'),
        ])
            ->where('due_date', '<', now())
            ->whereColumn('paid_amount', '<', 'expected_amount')
            ->update([
                'payment_status_id' => $overdueId,
            ]);

        return 0;
    }
}
