@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $event_payment_type->name }}</h1>
        <div class="flex gap-2">
            @can('update', $event_payment_type)
            <a href="{{ route('event_payment_types.edit', $event_payment_type) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Éditer
            </a>
            @endcan
            @can('delete', $event_payment_type)
            <form action="{{ route('event_payment_types.destroy', $event_payment_type) }}" method="POST" class="inline">
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
                <strong>Code:</strong> {{ $event_payment_type->code }}
            </div>
            <div>
                <strong>Montant:</strong> {{ number_format($event_payment_type->amount, 2) }} DA
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('event_payment_types.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Retour à la Liste
        </a>
    </div>
</div>
@endsection
