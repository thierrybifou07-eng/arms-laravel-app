<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventPaymentTypeRequest;
use App\Http\Requests\UpdateEventPaymentTypeRequest;
use App\Models\EventPaymentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventPaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', EventPaymentType::class);
        
        $eventPaymentTypes = EventPaymentType::paginate(15);
        return view('event_payment_types.index', compact('eventPaymentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', EventPaymentType::class);
        
        return view('event_payment_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventPaymentTypeRequest $request): RedirectResponse
    {
        $eventPaymentType = EventPaymentType::create($request->validated());
        
        return redirect()->route('event_payment_types.show', $eventPaymentType)
            ->with('success', 'Type de paiement d\'événement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventPaymentType $eventPaymentType): View
    {
        $this->authorize('view', $eventPaymentType);
        
        return view('event_payment_types.show', compact('eventPaymentType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventPaymentType $eventPaymentType): View
    {
        $this->authorize('update', $eventPaymentType);
        
        return view('event_payment_types.edit', compact('eventPaymentType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventPaymentTypeRequest $request, EventPaymentType $eventPaymentType): RedirectResponse
    {
        $eventPaymentType->update($request->validated());
        
        return redirect()->route('event_payment_types.show', $eventPaymentType)
            ->with('success', 'Type de paiement d\'événement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventPaymentType $eventPaymentType): RedirectResponse
    {
        $this->authorize('delete', $eventPaymentType);
        
        $eventPaymentType->delete();
        
        return redirect()->route('event_payment_types.index')
            ->with('success', 'Type de paiement d\'événement supprimé avec succès.');
    }
}
