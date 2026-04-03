<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillingPeriodRequest;
use App\Http\Requests\UpdateBillingPeriodRequest;
use App\Models\BillingPeriod;
use App\Models\Contract;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BillingPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', BillingPeriod::class);
        
        $billingPeriods = BillingPeriod::paginate(15);
        return view('billing_periods.index', compact('billingPeriods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', BillingPeriod::class);
        
        $contracts = Contract::all();
        return view('billing_periods.create', compact('contracts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillingPeriodRequest $request): RedirectResponse
    {
        $billingPeriod = BillingPeriod::create($request->validated());
        
        return redirect()->route('billing_periods.show', $billingPeriod)
            ->with('success', 'Période de facturation créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BillingPeriod $billingPeriod): View
    {
        $this->authorize('view', $billingPeriod);
        
        $contracts = $billingPeriod->contracts()->with('student', 'room')->get();
        return view('billing_periods.show', compact('billingPeriod', 'contracts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillingPeriod $billingPeriod): View
    {
        $this->authorize('update', $billingPeriod);
        
        return view('billing_periods.edit', compact('billingPeriod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBillingPeriodRequest $request, BillingPeriod $billingPeriod): RedirectResponse
    {
        $billingPeriod->update($request->validated());
        
        return redirect()->route('billing_periods.show', $billingPeriod)
            ->with('success', 'Période de facturation mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillingPeriod $billingPeriod): RedirectResponse
    {
        $this->authorize('delete', $billingPeriod);
        
        $billingPeriod->delete();
        
        return redirect()->route('billing_periods.index')
            ->with('success', 'Période de facturation supprimée avec succès.');
    }
}
