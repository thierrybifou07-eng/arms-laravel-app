<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', PaymentMethod::class);
        
        $paymentMethods = PaymentMethod::paginate(15);
        return view('payment_methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', PaymentMethod::class);
        
        return view('payment_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentMethodRequest $request): RedirectResponse
    {
        $paymentMethod = PaymentMethod::create($request->validated());
        
        return redirect()->route('payment_methods.show', $paymentMethod)
            ->with('success', 'Méthode de paiement créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod): View
    {
        $this->authorize('view', $paymentMethod);
        
        return view('payment_methods.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod): View
    {
        $this->authorize('update', $paymentMethod);
        
        return view('payment_methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        $paymentMethod->update($request->validated());
        
        return redirect()->route('payment_methods.show', $paymentMethod)
            ->with('success', 'Méthode de paiement mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod): RedirectResponse
    {
        $this->authorize('delete', $paymentMethod);
        
        $paymentMethod->delete();
        
        return redirect()->route('payment_methods.index')
            ->with('success', 'Méthode de paiement supprimée avec succès.');
    }
}
