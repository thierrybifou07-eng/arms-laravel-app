@extends('layouts.app')

@section('content')
<div class="col-xxl col-lg-12 col-md-12 flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('super_adminaudits.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="bx bx-arrow-back me-1"></i>Back to Audits
            </a>
            <h3 class="mb-0">Audit Record #{{ $audit->id }}</h3>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bx bx-trash me-1"></i>Delete
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Basic Info -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Record ID</label>
                        <p class="form-control-plaintext">{{ $audit->id }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Event</label>
                        <p class="form-control-plaintext">
                            @switch($audit->event)
                                @case('created')
                                    <span class="badge bg-success">{{ ucfirst($audit->event) }}</span>
                                @break

                                @case('updated')
                                    <span class="badge bg-info">{{ ucfirst($audit->event) }}</span>
                                @break

                                @case('deleted')
                                    <span class="badge bg-danger">{{ ucfirst($audit->event) }}</span>
                                @break

                                @case('restored')
                                    <span class="badge bg-warning">{{ ucfirst($audit->event) }}</span>
                                @break

                                @default
                                    <span class="badge bg-secondary">{{ ucfirst($audit->event) }}</span>
                            @endswitch
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Model</label>
                        <p class="form-control-plaintext">
                            <code>{{ class_basename($audit->auditable_type) }}</code>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Model Full Class</label>
                        <p class="form-control-plaintext">
                            <small><code>{{ $audit->auditable_type }}</code></small>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Auditable ID</label>
                        <p class="form-control-plaintext">{{ $audit->auditable_id }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Date & Time</label>
                        <p class="form-control-plaintext">
                            {{ $audit->created_at->format('M d, Y H:i:s') }}
                            <br>
                            <small class="text-muted">{{ $audit->created_at->diffForHumans() }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - User & Request Info -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Request Information</h5>
                </div>
                <div class="card-body">
                    @if ($audit->user)
                        <div class="mb-3">
                            <label class="form-label fw-bold">User</label>
                            <p class="form-control-plaintext">email: 
                                <strong>{{ $audit->user->email }}</strong>
                                <br>Name: 
                                {{ $audit->user->firstname }} {{ $audit->user->lastname }}
                                <br>Roles:
                                @if ($audit->user->roles->isNotEmpty())
                                    @foreach ($audit->user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->label }}</span>
                                    @endforeach
                                @endif
                            </p>
                        </div>
                    @else
                        <div class="mb-3">
                            <label class="form-label fw-bold">User</label>
                            <p class="form-control-plaintext">
                                <em class="text-muted">System / Unknown</em>
                            </p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">IP Address: </label>
                        <p class="form-control-plaintext">
                            {{ $audit->ip_address ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">URL</label>
                        <p class="form-control-plaintext">
                            <small><code>{{ $audit->url ?? 'N/A' }}</code></small>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">User Agent</label>
                        <p class="form-control-plaintext">
                            <small>{{ substr($audit->user_agent, 0, 80) ?? 'N/A' }}{{ strlen($audit->user_agent) > 80 ? '...' : '' }}</small>
                        </p>
                    </div>

                    @if ($audit->tags)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tags</label>
                            <p class="form-control-plaintext">
                                {{ $audit->tags }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Data Changes -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Data Changes</h5>
                </div>
                <div class="card-body">
                    @if ($audit->old_values || $audit->new_values)
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#oldValues">Old Values</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#newValues">New Values</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#comparison">Comparison</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3">
                            <div class="tab-pane fade show active" id="oldValues">
                                @if ($audit->old_values)
                                    <pre class="bg-light p-3 rounded"><code>{{ json_encode($audit->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                                @else
                                    <p class="text-muted"><em>No old values (likely a create event)</em></p>
                                @endif
                            </div>

                            <div class="tab-pane fade" id="newValues">
                                @if ($audit->new_values)
                                    <pre class="bg-light p-3 rounded"><code>{{ json_encode($audit->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                                @else
                                    <p class="text-muted"><em>No new values (likely a delete event)</em></p>
                                @endif
                            </div>

                            <div class="tab-pane fade" id="comparison">
                                @if ($audit->old_values && $audit->new_values)
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th>Field</th>
                                                    <th>Old Value</th>
                                                    <th>New Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $allKeys = array_unique(array_merge(array_keys((array) $audit->old_values), array_keys((array) $audit->new_values)));
                                                @endphp
                                                @foreach ($allKeys as $key)
                                                    @php
                                                        $oldValue = $audit->old_values[$key] ?? 'N/A';
                                                        $newValue = $audit->new_values[$key] ?? 'N/A';
                                                        $changed = $oldValue != $newValue;
                                                    @endphp
                                                    <tr class="{{ $changed ? 'table-warning' : '' }}">
                                                        <td><strong>{{ $key }}</strong></td>
                                                        <td><code>{{ json_encode($oldValue) }}</code></td>
                                                        <td><code>{{ json_encode($newValue) }}</code></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted"><em>Cannot display comparison for {{ $audit->event }} events</em></p>
                                @endif
                            </div>
                        </div>
                    @else
                        <p class="text-muted"><em>No data changes recorded</em></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('super_adminaudits.destroy', $audit) }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete Audit Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger mb-3">
                        <i class="bx bx-exclamation-circle me-2"></i>
                        This action cannot be undone. Please confirm your password.
                    </p>
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="delete_password" name="password"
                            placeholder="Enter your password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bx bx-trash me-1"></i>Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
