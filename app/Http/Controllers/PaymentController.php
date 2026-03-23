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
        $payments = Payment::with(['contract', 'status'])->latest()->paginate(10);

        return view('payments.index', compact('payments'));
    }

    /**
     */
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }
    /*
    |--------------------------------------------------------------------------
    | RECORDING A PAYMENT
    |--------------------------------------------------------------------------
    */

    public function pay(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'paid_amount' => 'required|numeric|min:0',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);
        $paidStatus = PaymentStatus::getIdByCodeOrFail('paid');
        $payment->update([
            'paid_amount' => $validated['paid_amount'],
            'payment_method_id' => $validated['payment_method_id'],
            'payment_status_id' => $paidStatus,
            'payment_date' => now(),
        ]);

        return back()->with('success', 'Payment recorded successfully.');
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
        $validatedStatus = PaymentStatus::getIdByCodeOrFail('validated');
        $activeStatus = ContractStatus::getIdByCodeOrFail('active');

        // Check the paid amount is equal to the expected amount
        if ($payment->paid_amount < $payment->expected_amount) {
            return back()->withErrors(['payment' => 'The paid amount is less than the expected amount.']);
        }
        $payment->update([
            'payment_status_id' => $validatedStatus,
        ]);
        // Activation of the contract after the payment validation
        $contract = $payment->contract;
        if ($contract->status->code === 'pending') {
            $contract->update([
                'contract_status_id' => $activeStatus,
            ]);
        }

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
        $cancelledStatus = PaymentStatus::getIdByCodeOrFail('cancelled');

        $payment->update([
            'payment_status_id' => $cancelledStatus,
        ]);
        return back()->with('success', 'The payment has been cancelled.');
    }
}