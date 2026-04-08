@extends('layouts.app')

@section('content')
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <div class="page-heading mb-3">
        <div class="row">
            <div class="col-12">
                <h4 class="mb-2">
                    <i class="menu-icon tf-icons icon-tabler icon-tabler-history"></i>
                    Details of the Audit Log
                </h4>
                <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary btn-sm">
                    <i class="icon-tabler icon-tabler-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">General Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Date and Time</label>
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
                                        <span class="badge bg-success">Creation</span>
                                    @break

                                    @case('UPDATE')
                                        <span class="badge bg-info">Modification</span>
                                    @break

                                    @case('DELETE')
                                        <span class="badge bg-danger">Deletion</span>
                                    @break

                                    @case('LOGIN')
                                        <span class="badge bg-primary">Login</span>
                                    @break

                                    @case('LOGOUT')
                                        <span class="badge bg-warning">Logout</span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">{{ $auditLog->action }}</span>
                                @endswitch
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Audit Type</label>
                            <p class="form-control-static">
                                @if ($auditLog->auditType)
                                    {{ $auditLog->auditType->label }}
                                @else
                                    <span class="text-muted">--</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Element Type</label>
                            <p class="form-control-static">
                                <code>{{ $auditLog->model_type ?? $auditLog->auditable_type }}</code>
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">User</label>
                            <p class="form-control-static">
                                @if ($auditLog->user)
                                    <strong>{{ $auditLog->user->firstname }} {{ $auditLog->user->lastname }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $auditLog->user->email }}</small>
                                @else
                                    <span class="badge bg-secondary">System</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Element ID</label>
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
                    <h5 class="card-title mb-0">Technical Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">IP Address</label>
                            <p class="form-control-static">
                                <code>{{ $auditLog->ip_address ?? 'N/A' }}</code>
                            </p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">HTTP Method</label>
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
                        <h5 class="card-title mb-0">Changes Made</h5>
                    </div>
                    <div class="card-body">
                        @if ($auditLog->action === 'UPDATE')
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Field</th>
                                            <th>Old Value</th>
                                            <th>New Value</th>
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
                                                    No change data available
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
                                            <th>Field</th>
                                            <th>Value</th>
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
                                                    No data available
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
                                            <th>Field</th>
                                            <th>Deleted Value</th>
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
                                                    No data available
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No change details available for this action.</p>
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
                        <h5 class="card-title mb-0">Additional Details</h5>
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
