@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-md">
    <h1 class="text-3xl font-bold mb-6">Ajouter une Période de Facturation</h1>

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('billing_periods.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror" required>
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label for="contract_id" class="block text-gray-700 text-sm font-bold mb-2">Contrat *</label>
            <select name="contract_id" id="contract_id" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('contract_id') border-red-500 @enderror" required>
                <option value="">-- Sélectionner un contrat --</option>
                @foreach($contracts as $contract)
                <option value="{{ $contract->id }}">{{ $contract->id }}</option>
                @endforeach
            </select>
            @error('contract_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Date de Début *</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('start_date') border-red-500 @enderror" required>
            @error('start_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-6">
            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Date de Fin *</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('end_date') border-red-500 @enderror" required>
            @error('end_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Créer
            </button>
            <a href="{{ route('billing_periods.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
