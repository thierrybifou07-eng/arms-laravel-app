@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>
                        <i class="menu-icon tf-icons icon-tabler icon-tabler-history"></i>
                        Logs d'Audit
                    </h3>
                    <p class="text-muted">Historique complet des actions effectuées dans le système</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Messages d'alerte --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading d-flex align-items-center">
                <i class="icon-tabler icon-tabler-alert-triangle me-2"></i>
                Erreur
            </h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Filtres de Recherche</h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#passwordModal">
                            <i class="icon-tabler icon-tabler-download"></i> Exporter
                        </button>
                        @if (auth()->user()->hasRole('super_admin'))
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#clearLogsModal">
                                <i class="icon-tabler icon-tabler-trash"></i> Vider
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('audit-logs.index') }}" class="row">
                        <div class="col-md-3 mb-3">
                            <label for="search" class="form-label">Recherche</label>
                            <input type="text" name="search" id="search" class="form-control"
                                placeholder="Utilisateur, détails..." value="{{ request('search') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="action" class="form-label">Type d'Action</label>
                            <select name="action" id="action" class="form-control">
                                <option value="">-- Tous --</option>
                                @foreach ($actions as $action)
                                    <option value="{{ $action }}" @selected(request('action') === $action)>
                                        {{ ucfirst(strtolower($action)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="audit_type" class="form-label">Type d'Audit</label>
                            <select name="audit_type" id="audit_type" class="form-control">
                                <option value="">-- Tous --</option>
                                @foreach ($auditTypes as $type)
                                    <option value="{{ $type->id }}" @selected(request('audit_type') == $type->id)>
                                        {{ $type->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="model_type" class="form-label">Type d'Élément</label>
                            <select name="model_type" id="model_type" class="form-control">
                                <option value="">-- Tous --</option>
                                @foreach ($modelTypes as $type)
                                    <option value="{{ $type }}" @selected(request('model_type') === $type)>
                                        {{ class_basename($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="start_date" class="form-label">Date Début</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="end_date" class="form-label">Date Fin</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="user_id" class="form-label">Utilisateur</label>
                            <input type="text" name="user_id" id="user_id" class="form-control"
                                placeholder="ID utilisateur" value="{{ request('user_id') }}">
                        </div>

                        <div class="col-md-3 d-flex align-items-end mb-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="icon-tabler icon-tabler-search"></i> Rechercher
                            </button>
                        </div>

                        <div class="col-md-3 d-flex align-items-end mb-3">
                            <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary w-100">
                                <i class="icon-tabler icon-tabler-reload"></i> Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Logs d'Audit ({{ $auditLogs->total() }} entrées)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date/Heure</th>
                                <th>Utilisateur</th>
                                <th>Action</th>
                                <th>Type</th>
                                <th>Élément</th>
                                <th>Détails</th>
                                <th>IP</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($auditLogs as $log)
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if ($log->user)
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <strong>{{ $log->user->firstname }}
                                                        {{ $log->user->lastname }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $log->user->email }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">Système</span>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($log->action)
                                            @case('CREATE')
                                                <span class="badge bg-success">Création</span>
                                            @break

                                            @case('UPDATE')
                                                <span class="badge bg-info">Modification</span>
                                            @break

                                            @case('DELETE')
                                                <span class="badge bg-danger">Suppression</span>
                                            @break

                                            @case('LOGIN')
                                                <span class="badge bg-primary">Connexion</span>
                                            @break

                                            @case('LOGOUT')
                                                <span class="badge bg-warning">Déconnexion</span>
                                            @break

                                            @default
                                                <span class="badge bg-secondary">{{ $log->action }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if ($log->auditType)
                                            {{ $log->auditType->label }}
                                        @else
                                            <span class="text-muted">--</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ class_basename($log->model_type) ?? $log->auditable_type }}</small>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($log->details, 50) }}</small>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $log->ip_address }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('audit-logs.show', $log) }}" class="btn btn-sm btn-info"
                                            title="Détails">
                                            <i class="icon-tabler icon-tabler-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Aucun log trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($auditLogs->hasPages())
                    <div class="card-footer">
                        {{ $auditLogs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal d'Export --}}
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">
                    <i class="icon-tabler icon-tabler-lock"></i> Vérification du Mot de Passe
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('audit-logs.export') }}" id="exportForm">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-3">
                        Pour accéder à l'export des logs, veuillez confirmer votre mot de passe :
                    </p>
                    <div class="mb-3">
                        <label for="exportPassword" class="form-label">Mot de Passe</label>
                        <input type="password" class="form-control" id="exportPassword" name="password"
                            required>
                    </div>
                    <input type="hidden" name="action" value="{{ request('action') }}">
                    <input type="hidden" name="audit_type" value="{{ request('audit_type') }}">
                    <input type="hidden" name="model_type" value="{{ request('model_type') }}">
                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                    <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="icon-tabler icon-tabler-download"></i> Exporter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal de Suppression des Logs --}}
@if (auth()->user()->hasRole('super_admin'))
    <div class="modal fade" id="clearLogsModal" tabindex="-1" aria-labelledby="clearLogsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="clearLogsModalLabel">
                        <i class="icon-tabler icon-tabler-alert-triangle"></i> Attention !
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('audit-logs.clear') }}" id="clearForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="alert alert-warning" role="alert">
                            <strong>Cette action est irréversible !</strong>
                            <p class="mb-0 mt-2">Tous les logs d'audit seront supprimés définitivement de la base de
                                données.</p>
                        </div>
                        <p class="text-muted mb-3">
                            Pour confirmer la suppression, veuillez saisir votre mot de passe :
                        </p>
                        <div class="mb-3">
                            <label for="clearPassword" class="form-label">Mot de Passe</label>
                            <input type="password" class="form-control" id="clearPassword" name="password"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="icon-tabler icon-tabler-trash"></i> Supprimer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<script>
    // Clear password field on modal close
    document.getElementById('passwordModal')?.addEventListener('hidden.bs.modal', function() {
        document.getElementById('exportPassword').value = '';
    });

    document.getElementById('clearLogsModal')?.addEventListener('hidden.bs.modal', function() {
        document.getElementById('clearPassword').value = '';
    });
</script>
@endsection
