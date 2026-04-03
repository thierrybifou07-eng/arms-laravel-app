@extends('layouts.app')

@section('content')
    <div class="col-xxl-12 my-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Créer un Nouvel Étudiant</h5>
                <small class="text-body-secondary float-end">À partir d'un utilisateur existant</small>
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
                <form method="POST" action="{{ route('students.store') }}">
                    @csrf
                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="user_id">Utilisateur *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-user"></i></span>
                                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner un utilisateur --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                            {{ $user->firstname }} {{ $user->lastname }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('user_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="surname">Nom Famille *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-user-circle"></i></span>
                                <input type="text" name="surname" id="surname" value="{{ old('surname') }}"
                                    class="form-control @error('surname') is-invalid @enderror"
                                    placeholder="Entrez le nom de famille" required>
                            </div>
                            @error('surname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="given_name">Prénom *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-user-circle"></i></span>
                                <input type="text" name="given_name" id="given_name" value="{{ old('given_name') }}"
                                    class="form-control @error('given_name') is-invalid @enderror"
                                    placeholder="Entrez le prénom" required>
                            </div>
                            @error('given_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="middlename">Deuxième Prénom</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-user-circle"></i></span>
                                <input type="text" name="middlename" id="middlename" value="{{ old('middlename') }}"
                                    class="form-control" placeholder="Optionnel">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="identification_number">Numéro d'ID *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-id-card"></i></span>
                                <input type="text" name="identification_number" id="identification_number"
                                    value="{{ old('identification_number') }}"
                                    class="form-control @error('identification_number') is-invalid @enderror"
                                    placeholder="Numéro d'identification" required>
                            </div>
                            @error('identification_number')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="phone">Téléphone *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-phone"></i></span>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="+213 XX XX XX XX" required>
                            </div>
                            @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="email">Email *</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-envelope"></i></span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="exemple@email.com" required>
                            </div>
                            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary me-2">Créer Étudiant</button>
                            <a href="{{ route('students.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
