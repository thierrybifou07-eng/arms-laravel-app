<?php

namespace App\Http\Controllers;

use App\Models\PaymentHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', PaymentHistory::class);
        
        $paymentHistories = PaymentHistory::with('payment')->paginate(20);
        return view('payment_histories.index', compact('paymentHistories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', PaymentHistory::class);
        
        return view('payment_histories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', PaymentHistory::class);

        $validated = $request->validate([
            'payment_id' => ['required', 'exists:payments,id'],
            'status_code' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'recorded_by' => ['required', 'exists:users,id'],
        ]);

        $paymentHistory = PaymentHistory::create($validated);
        
        return redirect()->route('payment_histories.show', $paymentHistory)
            ->with('success', 'Historique de paiement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentHistory $paymentHistory): View
    {
        $this->authorize('view', $paymentHistory);
        
        return view('payment_histories.show', compact('paymentHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     * Payment history is typically immutable, but provided for admin access
     */
    public function edit(PaymentHistory $paymentHistory): View
    {
        $this->authorize('update', $paymentHistory);
        
        return view('payment_histories.edit', compact('paymentHistory'));
    }

    /**
     * Update the specified resource in storage.
     * Payment history should rarely be updated - only by super admin
     */
    public function update(Request $request, PaymentHistory $paymentHistory): RedirectResponse
    {
        $this->authorize('update', $paymentHistory);

        $validated = $request->validate([
            'notes' => ['nullable', 'string'],
        ]);

        $paymentHistory->update($validated);
        
        return redirect()->route('payment_histories.show', $paymentHistory)
            ->with('success', 'Historique de paiement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentHistory $paymentHistory): RedirectResponse
    {
        $this->authorize('delete', $paymentHistory);
        
        $paymentHistory->delete();
        
        return redirect()->route('payment_histories.index')
            ->with('success', 'Historique de paiement supprimé avec succès.');
    }

    /**
     * Export payment history
     */
    public function export(Request $request): mixed
    {
        $this->authorize('export', PaymentHistory::class);

        // Export logic here if needed
        return response()->download('path/to/export.csv');
    }
}
