@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Entrée d'Historique</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Détails</h2>
        <div class="space-y-3">
            <div>
                <strong>Paiement ID:</strong> {{ $payment_history->payment_id }}
            </div>
            <div>
                <strong>Montant:</strong> {{ number_format($payment_history->amount, 2) }} DA
            </div>
            <div>
                <strong>Ancien Solde:</strong> {{ number_format($payment_history->old_balance, 2) }} DA
            </div>
            <div>
                <strong>Nouveau Solde:</strong> {{ number_format($payment_history->new_balance, 2) }} DA
            </div>
            <div>
                <strong>Notes:</strong> 
                @if($payment_history->notes)
                    {{ $payment_history->notes }}
                @else
                    <em>Aucune note</em>
                @endif
            </div>
            <div>
                <strong>Créé le:</strong> {{ $payment_history->created_at->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('payment_histories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Retour à la Liste
        </a>
    </div>
</div>
@endsection
