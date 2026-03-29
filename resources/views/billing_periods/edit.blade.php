@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-md">
    <h1 class="text-3xl font-bold mb-6">Éditer Période de Facturation</h1>

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('billing_periods.update', $billing_period) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $billing_period->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror" required>
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Date de Début *</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $billing_period->start_date->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('start_date') border-red-500 @enderror" required>
            @error('start_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-6">
            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Date de Fin *</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $billing_period->end_date->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('end_date') border-red-500 @enderror" required>
            @error('end_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Mettre à Jour
            </button>
            <a href="{{ route('billing_periods.show', $billing_period) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
