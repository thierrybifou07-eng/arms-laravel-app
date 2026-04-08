@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="page-heading mb-4">
        <div class="row">
            <div class="col-12">
                <h3 class="mb-2">
                    <i class="menu-icon tf-icons icon-tabler icon-tabler-history"></i>
                    Détails du Log d'Audit
                </h3>
                <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary btn-sm">
                    <i class="icon-tabler icon-tabler-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations Générales</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Date et Heure</label>
                            <p class="form-control-static">
                                {{ $auditLog->created_at->format('d/m/Y H:i:s') }}
                                <small class="text-muted">({{ $auditLog->created_at->diffForHumans() }})</small>
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Action</label>
                            <p class="form-control-static">
                                @switch($auditLog->action)
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
                                        <span class="badge bg-secondary">{{ $auditLog->action }}</span>
                                @endswitch
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Type d'Audit</label>
                            <p class="form-control-static">
                                @if ($auditLog->auditType)
                                    {{ $auditLog->auditType->label }}
                                @else
                                    <span class="text-muted">--</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Type d'Élément</label>
                            <p class="form-control-static">
                                <code>{{ $auditLog->model_type ?? $auditLog->auditable_type }}</code>
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Utilisateur</label>
                            <p class="form-control-static">
                                @if ($auditLog->user)
                                    <strong>{{ $auditLog->user->firstname }} {{ $auditLog->user->lastname }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $auditLog->user->email }}</small>
                                @else
                                    <span class="badge bg-secondary">Système</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">ID l'Élément</label>
                            <p class="form-control-static">
                                {{ $auditLog->model_id ?? $auditLog->auditable_id ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Détails Techniques</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Adresse IP</label>
                            <p class="form-control-static">
                                <code>{{ $auditLog->ip_address ?? 'N/A' }}</code>
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Méthode HTTP</label>
                            <p class="form-control-static">
                                <span class="badge bg-primary">{{ $auditLog->method ?? 'N/A' }}</span>
                            </p>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold">URL</label>
                            <p class="form-control-static">
                                <code class="d-block text-break">{{ $auditLog->url ?? 'N/A' }}</code>
                            </p>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold">User Agent</label>
                            <p class="form-control-static">
                                <small class="d-block text-break">{{ $auditLog->user_agent ?? 'N/A' }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($auditLog->old_values || $auditLog->new_values)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Changements Effectués</h5>
                    </div>
                    <div class="card-body">
                        @if ($auditLog->action === 'UPDATE')
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Champ</th>
                                            <th>Ancienne Valeur</th>
                                            <th>Nouvelle Valeur</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($auditLog->old_values && $auditLog->new_values)
                                            @foreach ($auditLog->new_values as $key => $newValue)
                                                <tr>
                                                    <td><strong>{{ $key }}</strong></td>
                                                    <td>
                                                        <code class="text-danger">
                                                            {{ $auditLog->old_values[$key] ?? 'N/A' }}
                                                        </code>
                                                    </td>
                                                    <td>
                                                        <code class="text-success">
                                                            {{ $newValue }}
                                                        </code>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">
                                                    Aucune donnée de changement disponible
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @elseif ($auditLog->action === 'CREATE')
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Champ</th>
                                            <th>Valeur</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($auditLog->new_values)
                                            @foreach ($auditLog->new_values as $key => $value)
                                                <tr>
                                                    <td><strong>{{ $key }}</strong></td>
                                                    <td><code class="text-success">{{ $value }}</code></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2" class="text-center text-muted">
                                                    Aucune donnée disponible
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @elseif ($auditLog->action === 'DELETE')
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Champ</th>
                                            <th>Valeur Supprimée</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($auditLog->old_values)
                                            @foreach ($auditLog->old_values as $key => $value)
                                                <tr>
                                                    <td><strong>{{ $key }}</strong></td>
                                                    <td><code class="text-danger">{{ $value }}</code></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2" class="text-center text-muted">
                                                    Aucune donnée disponible
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Pas de détails de changement pour cette action.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($auditLog->details)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Détails Supplémentaires</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $auditLog->details }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
