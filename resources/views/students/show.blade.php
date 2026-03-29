@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $student->surname }} {{ $student->given_name }}</h1>
        <div class="flex gap-2">
            @can('update', $student)
            <a href="{{ route('students.edit', $student) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Éditer
            </a>
            @endcan
            @can('delete', $student)
            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Êtes-vous sûr?')">
                    Supprimer
                </button>
            </form>
            @endcan
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Informations Personnelles</h2>
            <div class="space-y-3">
                <div>
                    <strong>Nom Famille:</strong> {{ $student->surname }}
                </div>
                <div>
                    <strong>Prénom:</strong> {{ $student->given_name }}
                </div>
                @if($student->middlename)
                <div>
                    <strong>Deuxième Prénom:</strong> {{ $student->middlename }}
                </div>
                @endif
                <div>
                    <strong>ID:</strong> {{ $student->identification_number }}
                </div>
                <div>
                    <strong>Téléphone:</strong> {{ $student->phone }}
                </div>
                <div>
                    <strong>Email:</strong> {{ $student->email }}
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Contrats</h2>
            @if($contracts->count() > 0)
            <ul class="space-y-2">
                @foreach($contracts as $contract)
                <li>
                    <a href="{{ route('contracts.show', $contract) }}" class="text-blue-600 hover:text-blue-900">
                        {{ $contract->room->room_number }} - {{ $contract->status->name }}
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <p class="text-gray-500">Aucun contrat trouvé.</p>
            @endif
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('students.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Retour à la Liste
        </a>
    </div>
</div>
@endsection
