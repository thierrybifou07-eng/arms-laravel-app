<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentStatusRequest;
use App\Http\Requests\UpdatePaymentStatusRequest;
use App\Models\PaymentStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', PaymentStatus::class);
        
        $paymentStatuses = PaymentStatus::paginate(15);
        return view('payment_statuses.index', compact('paymentStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', PaymentStatus::class);
        
        return view('payment_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentStatusRequest $request): RedirectResponse
    {
        $paymentStatus = PaymentStatus::create($request->validated());
        
        return redirect()->route('payment_statuses.show', $paymentStatus)
            ->with('success', 'Statut de paiement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentStatus $paymentStatus): View
    {
        $this->authorize('view', $paymentStatus);
        
        return view('payment_statuses.show', compact('paymentStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentStatus $paymentStatus): View
    {
        $this->authorize('update', $paymentStatus);
        
        return view('payment_statuses.edit', compact('paymentStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentStatusRequest $request, PaymentStatus $paymentStatus): RedirectResponse
    {
        $paymentStatus->update($request->validated());
        
        return redirect()->route('payment_statuses.show', $paymentStatus)
            ->with('success', 'Statut de paiement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentStatus $paymentStatus): RedirectResponse
    {
        $this->authorize('delete', $paymentStatus);
        
        $paymentStatus->delete();
        
        return redirect()->route('payment_statuses.index')
            ->with('success', 'Statut de paiement supprimé avec succès.');
    }
}
