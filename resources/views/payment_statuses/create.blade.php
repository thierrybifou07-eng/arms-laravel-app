@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-md">
    <h1 class="text-3xl font-bold mb-6">Ajouter un Statut de Paiement</h1>

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('payment_statuses.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror" required>
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-6">
            <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Code *</label>
            <input type="text" name="code" id="code" value="{{ old('code') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('code') border-red-500 @enderror" required>
            @error('code')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Créer
            </button>
            <a href="{{ route('payment_statuses.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
