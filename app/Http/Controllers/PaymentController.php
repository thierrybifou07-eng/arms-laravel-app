<?php

namespace App\Http\Controllers;

use App\Models\ContractStatus;
use App\Models\Payment;
use App\Models\PaymentStatus;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['contract.student', 'status'])->latest()->get();

        // filtre
        if (request('status') === 'overdue') {
            $payments = $payments->filter(fn ($p) => $p->isOverdue());
        }

        if (request('status') === 'pending') {
            $payments = $payments->where('status.code', 'pending');
        }
        if (request('status') === 'processing') {
            $payments = $payments->where('status.code', 'processing');
        }

        if (request('status') === 'validated') {
            $payments = $payments->where('status.code', 'validated');
        }

        return view('payments.index', compact('payments'));
    }

    // send payment with their methods
    public function show(Payment $payment)
    {
        $payment->load(['contract', 'status']);
        $paymentMethods = \App\Models\PaymentMethod::all();

        return view('payments.show', compact('payment', 'paymentMethods'));
    }
    /*
    |--------------------------------------------------------------------------
    | RECORDING A PAYMENT
    |--------------------------------------------------------------------------
    */

    public function pay(Request $request, Payment $payment)
    {
        //  stop double payment
        if ($payment->paid_amount >= $payment->expected_amount) {
            return back()->withErrors(['payment' => 'Already fully paid.']);
        }

        $validated = $request->validate([
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $processingStatus = PaymentStatus::getIdByCodeOrFail('processing');

        $payment->update([
            'paid_amount' => $validated['paid_amount'],
            'payment_method_id' => $validated['payment_method_id'],
            'payment_status_id' => $processingStatus,
            'payment_date' => now(),
        ]);

        return back()->with('success', 'Payment submitted for validation.');
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION OF THE PAYMENT RECORDED(Important!!)
    |--------------------------------------------------------------------------
    */
    /**
     * Show the form for editing the specified resource.
     */
    public function validatePayment(Payment $payment)
    {
        //  security
        if ($payment->payment_status_id === PaymentStatus::getIdByCodeOrFail('validated')) {
            return back()->withErrors(['payment' => 'Already validated.']);
        }

        if ($payment->paid_amount < $payment->expected_amount) {
            return back()->withErrors(['payment' => 'Insufficient payment amount.']);
        }

        $validatedStatus = PaymentStatus::getIdByCodeOrFail('validated');
        $activeStatus = ContractStatus::getIdByCodeOrFail('active');

        $payment->update([
            'payment_status_id' => $validatedStatus,
        ]);

        $contract = $payment->contract;

        //  activation
        if (in_array($contract->status->code, ['pending', 'overdue'])) {
            $contract->update([
                'contract_status_id' => $activeStatus,
            ]);
        }

        //  cheks métier
        $contract->refresh();
        $contract->checkOverdue();
        $contract->checkExpired();

        return back()->with('success', 'Payment validated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION OF THE PAYMENT RECORDED(Important!!)
    |--------------------------------------------------------------------------
    */
    /**
     * Show the form for editing the specified resource.
     */
    public function cancel(Payment $payment)
    {
        if ($payment->paid_amount > 0) {
            return back()->withErrors(['payment' => 'Cannot cancel a paid payment.']);
        }

        $cancelledStatus = PaymentStatus::getIdByCodeOrFail('cancelled');

        $payment->update([
            'payment_status_id' => $cancelledStatus,
        ]);

        return back()->with('success', 'The payment has been cancelled.');
    }
}
