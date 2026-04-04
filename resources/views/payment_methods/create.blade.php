@extends('layouts.app')

@section('content')
    <div class="col-xxl-12 my-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Créer une Méthode de Paiement</h5>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Erreurs:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card-body">
                <form method="POST" action="{{ route('payment_methods.store') }}">
                    @csrf
                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name">Nom *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-credit-card"></i></span>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                            </div>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="code">Code *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-code"></i></span>
                                <input type="text" name="code" id="code" value="{{ old('code') }}"
                                    class="form-control @error('code') is-invalid @enderror" required>
                            </div>
                            @error('code')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary me-2">Créer</button>
                            <a href="{{ route('payment_methods.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
