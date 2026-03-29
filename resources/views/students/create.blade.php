@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-md">
    <h1 class="text-3xl font-bold mb-6">Ajouter un Étudiant</h1>

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('students.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        
        <div class="mb-4">
            <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Utilisateur *</label>
            <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('user_id') border-red-500 @enderror" required>
                <option value="">-- Sélectionner un utilisateur --</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->lastname }}</option>
                @endforeach
            </select>
            @error('user_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label for="surname" class="block text-gray-700 text-sm font-bold mb-2">Nom Famille *</label>
            <input type="text" name="surname" id="surname" value="{{ old('surname') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('surname') border-red-500 @enderror" required>
            @error('surname')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label for="given_name" class="block text-gray-700 text-sm font-bold mb-2">Prénom *</label>
            <input type="text" name="given_name" id="given_name" value="{{ old('given_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('given_name') border-red-500 @enderror" required>
            @error('given_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label for="middlename" class="block text-gray-700 text-sm font-bold mb-2">Deuxième Prénom</label>
            <input type="text" name="middlename" id="middlename" value="{{ old('middlename') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            @error('middlename')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label for="identification_number" class="block text-gray-700 text-sm font-bold mb-2">Numéro d'Identification *</label>
            <input type="text" name="identification_number" id="identification_number" value="{{ old('identification_number') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('identification_number') border-red-500 @enderror" required>
            @error('identification_number')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Téléphone *</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('phone') border-red-500 @enderror" required>
            @error('phone')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="mb-6">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email *</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('email') border-red-500 @enderror" required>
            @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Créer
            </button>
            <a href="{{ route('students.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
