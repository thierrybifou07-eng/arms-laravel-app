@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $billing_period->name }}</h1>
        <div class="flex gap-2">
            @can('update', $billing_period)
            <a href="{{ route('billing_periods.edit', $billing_period) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Éditer
            </a>
            @endcan
            @can('delete', $billing_period)
            <form action="{{ route('billing_periods.destroy', $billing_period) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Êtes-vous sûr?')">
                    Supprimer
                </button>
            </form>
            @endcan
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Détails</h2>
        <div class="space-y-3">
            <div>
                <strong>Contrat:</strong> {{ $billing_period->contract_id }}
            </div>
            <div>
                <strong>Date de Début:</strong> {{ $billing_period->start_date->format('d/m/Y') }}
            </div>
            <div>
                <strong>Date de Fin:</strong> {{ $billing_period->end_date->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('billing_periods.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Retour à la Liste
        </a>
    </div>
</div>
@endsection
