@extends('layouts.app')

@section('content')
    <div class="col-xxl-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card my-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Informations Personnelles</h5>
                        @can('update', $student)
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">
                            <i class="icon-base bx bx-edit me-1"></i> Éditer
                        </a>
                        @endcan
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-borderless">
                            <tbody class="table-border-bottom-0">
                                <tr>
                                    <td class="fw-medium">Nom Complet:</td>
                                    <td>{{ $student->surname }} {{ $student->given_name }}
                                        @if ($student->middlename)
                                            {{ $student->middlename }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">ID Étudiant:</td>
                                    <td>{{ $student->identification_number }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Email:</td>
                                    <td>{{ $student->email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Téléphone:</td>
                                    <td>{{ $student->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Utilisateur Lié:</td>
                                    <td>
                                        @if ($student->user)
                                            <a href="{{ route('users.show', $student->user) }}">
                                                {{ $student->user->firstname }} {{ $student->user->lastname }}
                                            </a>
                                        @else
                                            <span class="badge bg-warning">Aucun utilisateur</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Créé le:</td>
                                    <td>{{ $student->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Mis à jour le:</td>
                                    <td>{{ $student->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card my-4">
                    <div class="card-header">
                        <h5 class="mb-0">Contrats</h5>
                    </div>
                    @if ($contracts->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($contracts as $contract)
                                <a href="{{ route('contracts.show', $contract) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $contract->room->room_number ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $contract->status->label ?? 'N/A' }}</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $contract->created_at->format('d/m/Y') }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="card-body">
                            <p class="text-muted text-center mb-0">Aucun contrat trouvé.</p>
                        </div>
                    @endif
                </div>

                @can('delete', $student)
                <div class="card border-danger my-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Zone Dangereuse</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('students.destroy', $student) }}" class="mb-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100"
                                onclick="return confirm('Êtes-vous absolument sûr? Cette action est irréversible.')">
                                <i class="icon-base bx bx-trash me-1"></i> Supprimer Étudiant
                            </button>
                        </form>
                    </div>
                </div>
                @endcan
            </div>
        </div>

        <div class="demo-inline-spacing">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                <i class="icon-base bx bx-arrow-back me-1"></i> Retour à la Liste
            </a>
        </div>
    </div>
@endsection
