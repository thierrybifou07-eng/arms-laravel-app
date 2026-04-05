<?php

namespace App\Http\Controllers;

use App\Models\ContractStatus;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['contract.user', 'status'])->latest()->paginate(15);

        // filtre
        if (request('status') === 'overdue') {
            $payments = $payments->getCollection()->filter(fn ($p) => $p->isOverdue());
        }

        if (request('status') === 'pending') {
            $payments = $payments->where('payment_statuses.code', 'pending');
        }
        if (request('status') === 'processing') {
            $payments = $payments->where('payment_statuses.code', 'processing');
        }

        if (request('status') === 'validated') {
            $payments = $payments->where('payment_statuses.code', 'validated');
        }

        return view('payments.index', compact('payments'));
    }

    public function payForm(Payment $payment)
    {
        if ($payment->status->code === 'validated') {
            return redirect()->route('payments.show.pay', $payment)->withErrors('Ce paiement est déjà validé');
        }
        $paymentMethods = \App\Models\PaymentMethod::all();

        return view('payments.pay', compact('payment', 'paymentMethods'));
    }

    public function showPay(Payment $payment)
    {
        $payment->load(['contract', 'status']);
        $paymentMethods = \App\Models\PaymentMethod::all();

        return view('payments.show', compact('payment', 'paymentMethods'));
    }

    public function pay(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $paidAmount = (float) $validated['paid_amount'];
        $expected = (float) $payment->expected_amount;
/*         $tip = max(0, $paidAmount - $expected);
 */
        $processingStatus = PaymentStatus::getIdByCodeOrFail('processing');

        DB::transaction(function () use ($payment, $paidAmount/* , $tip */, $validated, $processingStatus) {
            $payment->update([
                'paid_amount' => $paidAmount,
/*                 'tip_amount' => $tip,
 */                'payment_method_id' => $validated['payment_method_id'],
                'payment_status_id' => $processingStatus,
                'payment_date' => now(),
            ]);
        });

        return back()->with('success', 'Payment submitted for validation.');
    }

    public function validatePayment(Payment $payment)
    {
        if ($payment->payment_status_id === PaymentStatus::getIdByCodeOrFail('validated')) {
            return back()->withErrors(['payment' => 'Already validated.']);
        }

        if ($payment->paid_amount < $payment->expected_amount) {
            return back()->withErrors(['payment' => 'Insufficient amount.']);
        }

        $validatedStatus = PaymentStatus::getIdByCodeOrFail('validated');
        $activeStatus = ContractStatus::getIdByCodeOrFail('active');

        DB::transaction(function () use ($payment, $validatedStatus, $activeStatus) {
            $payment->update(['payment_status_id' => $validatedStatus]);

            $contract = $payment->contract;
            if (in_array($contract->status->code, ['pending', 'overdue'])) {
                $contract->update(['contract_status_id' => $activeStatus]);
            }

            // Enregistrer dans historique
            PaymentHistory::create([
                'payment_id' => $payment->id,
                'amount' => $payment->paid_amount,
                'old_balance' => $contract->user->balance ?? 0,
                'new_balance' => ($contract->user->balance ?? 0) + $payment->paid_amount,
            ]);

            $contract->refresh();
            $contract->checkOverdue();
            $contract->checkExpired();
        });

        return back()->with('success', 'Payment validated successfully.');
    }

    public function cancel(Payment $payment)
    {
        if ($payment->paid_amount > 0) {
            return back()->withErrors(['payment' => 'Cannot cancel a payment that has been paid.']);
        }

        $cancelledStatus = PaymentStatus::getIdByCodeOrFail('cancelled');

        $payment->update(['payment_status_id' => $cancelledStatus]);

        return back()->with('success', 'The payment has been cancelled.');
    }
}
