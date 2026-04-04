@extends('layouts.app')
@section('content')
    <div class="col-xxl-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card my-5">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Liste des Étudiants</h5>
                @can('create', App\Models\Student::class)
                <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">
                    <i class="icon-base bx bx-plus me-1"></i> Ajouter Étudiant
                </a>
                @endcan
            </div>
            @if ($students->count() > 0)
                <div class="table-responsive table-hover text-nowrap">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Nom Complet</th>
                                <th>ID Étudiant</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Utilisateur</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($students as $student)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $student->surname }} {{ $student->given_name }}</span>
                                    </td>
                                    <td>{{ $student->identification_number }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->user->firstname ?? 'N/A' }} {{ $student->user->lastname ?? '' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('view', $student)
                                                <a class="dropdown-item"
                                                    href="{{ route('students.show', $student) }}">
                                                    <i class="icon-base bx bx-show-alt me-1"></i>Voir</a>
                                                @endcan
                                                @can('update', $student)
                                                <a class="dropdown-item"
                                                    href="{{ route('students.edit', $student) }}"><i
                                                        class="icon-base bx bx-edit me-1"></i>Éditer</a>
                                                @endcan
                                                @can('delete', $student)
                                                <hr class="dropdown-divider">
                                                <form method="POST"
                                                    action="{{ route('students.destroy', $student) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger" type="submit"
                                                        onclick="return confirm('Êtes-vous sûr?')">
                                                        <i class="icon-base bx bx-trash me-1"></i>Supprimer
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="demo-inline-spacing mx-5">
                        <a class="btn rounded-pill btn-primary" href="{{ route('students.create') }}">
                            Aucun étudiant trouvé - Créer un nouveau </a>
                    </div>
                </div>
            @endif
        </div>
        @if ($students->count() > 0)
            <div class="demo-inline-spacing mx-5">
                {{ $students->links() }}
            </div>
        @endif
    </div>
@endsection
