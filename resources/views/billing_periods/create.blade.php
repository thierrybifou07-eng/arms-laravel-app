@extends('layouts.app')

@section('content')
    <div class="col-xxl-12 my-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Créer une Période de Facturation</h5>
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
                <form method="POST" action="{{ route('billing_periods.store') }}">
                    @csrf
                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name">Nom *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-calendar"></i></span>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                            </div>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="contract_id">Contrat *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-file"></i></span>
                                <select name="contract_id" id="contract_id" class="form-select @error('contract_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner un contrat --</option>
                                    @foreach ($contracts as $contract)
                                        <option value="{{ $contract->id }}" @selected(old('contract_id') == $contract->id)>
                                            Contrat #{{ $contract->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('contract_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="start_date">Date de Début *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-calendar"></i></span>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                    class="form-control @error('start_date') is-invalid @enderror" required>
                            </div>
                            @error('start_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="end_date">Date de Fin *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-calendar"></i></span>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                    class="form-control @error('end_date') is-invalid @enderror" required>
                            </div>
                            @error('end_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary me-2">Créer</button>
                            <a href="{{ route('billing_periods.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
