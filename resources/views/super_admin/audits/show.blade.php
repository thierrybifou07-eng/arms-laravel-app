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
                                <br>Role:
                                @php
                                    $userRole = $audit->user->getRole();
                                @endphp
                                @if ($userRole)
                                    <span class="badge bg-primary">{{ $userRole->label }}</span>
                                @else
                                    <span class="text-muted">No role assigned</span>
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
                <div class="card-header bg-light d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="bx bx-git-compare me-2"></i>Data Changes
                    </h5>
                    @if ($audit->event === 'created')
                        <span class="badge bg-success">New Record Created</span>
                    @elseif ($audit->event === 'deleted')
                        <span class="badge bg-danger">Record Deleted</span>
                    @elseif ($audit->event === 'restored')
                        <span class="badge bg-warning">Record Restored</span>
                    @endif
                </div>
                <div class="card-body">
                    @if ($audit->old_values || $audit->new_values)
                        @if ($audit->event === 'created' && $audit->new_values)
                            <!-- Created Event - Show new values -->
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong>New Record Created</strong> - All fields listed below are newly added values.
                            </div>
                            <div class="row">
                                @foreach ($audit->new_values as $key => $value)
                                    <div class="col-md-6 mb-3">
                                        <div class="p-3 border rounded bg-light">
                                            <label class="form-label fw-bold text-success mb-2">
                                                <i class="bx bx-plus-circle me-1"></i>{{ ucwords(str_replace('_', ' ', $key)) }}
                                            </label>
                                            <div class="value-box p-2 bg-white rounded border-start border-success border-3">
                                                @php
                                                    $displayValue = is_array($value) || is_object($value) 
                                                        ? json_encode($value, JSON_PRETTY_PRINT) 
                                                        : (is_bool($value) ? ($value ? 'Yes' : 'No') : ($value ?? '—'));
                                                @endphp
                                                <small class="text-dark">{{ $displayValue }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($audit->event === 'deleted' && $audit->old_values)
                            <!-- Deleted Event - Show old values -->
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bx bx-x-circle me-2"></i>
                                <strong>Record Deleted</strong> - Listed below are the values that were deleted.
                            </div>
                            <div class="row">
                                @foreach ($audit->old_values as $key => $value)
                                    <div class="col-md-6 mb-3">
                                        <div class="p-3 border rounded bg-light">
                                            <label class="form-label fw-bold text-danger mb-2">
                                                <i class="bx bx-minus-circle me-1"></i>{{ ucwords(str_replace('_', ' ', $key)) }}
                                            </label>
                                            <div class="value-box p-2 bg-white rounded border-start border-danger border-3">
                                                @php
                                                    $displayValue = is_array($value) || is_object($value) 
                                                        ? json_encode($value, JSON_PRETTY_PRINT) 
                                                        : (is_bool($value) ? ($value ? 'Yes' : 'No') : ($value ?? '—'));
                                                @endphp
                                                <small class="text-dark text-decoration-line-through">{{ $displayValue }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif (($audit->event === 'updated' || $audit->event === 'restored') && ($audit->old_values && $audit->new_values))
                            <!-- Updated Event - Show comparison -->
                            <ul class="nav nav-tabs" role="tablist" class="mb-3">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#changesComparison">
                                        <i class="bx bx-git-compare me-1"></i>Comparison
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#rawJson">
                                        <i class="bx bx-code me-1"></i>Raw JSON
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3">
                                <div class="tab-pane fade show active" id="changesComparison">
                                    @php
                                        $allKeys = array_unique(array_merge(
                                            array_keys((array) $audit->old_values), 
                                            array_keys((array) $audit->new_values)
                                        ));
                                        sort($allKeys);
                                    @endphp
                                    <div class="row">
                                        @foreach ($allKeys as $key)
                                            @php
                                                $oldValue = $audit->old_values[$key] ?? null;
                                                $newValue = $audit->new_values[$key] ?? null;
                                                $hasChanged = $oldValue !== $newValue;
                                            @endphp
                                            <div class="col-lg-6 mb-4">
                                                <div class="card border {{ $hasChanged ? 'border-warning' : 'border-success' }} h-100">
                                                    <div class="card-header bg-{{ $hasChanged ? 'light' : 'success' }} bg-opacity-10 py-2">
                                                        <h6 class="mb-0">
                                                            @if ($hasChanged)
                                                                <i class="bx bx-edit text-warning me-2"></i>
                                                            @else
                                                                <i class="bx bx-check text-success me-2"></i>
                                                            @endif
                                                            {{ ucwords(str_replace('_', ' ', $key)) }}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body p-3">
                                                        <div class="mb-3">
                                                            <label class="form-label mb-2 text-danger fw-bold">
                                                                <i class="bx bx-arrow-from-right me-1"></i>Before
                                                            </label>
                                                            <div class="p-2 bg-danger bg-opacity-10 rounded border-start border-danger border-3">
                                                                @php
                                                                    $displayOld = is_array($oldValue) || is_object($oldValue) 
                                                                        ? json_encode($oldValue, JSON_PRETTY_PRINT) 
                                                                        : (is_bool($oldValue) ? ($oldValue ? 'Yes' : 'No') : ($oldValue ?? '—'));
                                                                @endphp
                                                                <small class="text-dark font-monospace">{{ $displayOld }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="mb-0">
                                                            <label class="form-label mb-2 text-success fw-bold">
                                                                <i class="bx bx-arrow-to-right me-1"></i>After
                                                            </label>
                                                            <div class="p-2 bg-success bg-opacity-10 rounded border-start border-success border-3">
                                                                @php
                                                                    $displayNew = is_array($newValue) || is_object($newValue) 
                                                                        ? json_encode($newValue, JSON_PRETTY_PRINT) 
                                                                        : (is_bool($newValue) ? ($newValue ? 'Yes' : 'No') : ($newValue ?? '—'));
                                                                @endphp
                                                                <small class="text-dark font-monospace">{{ $displayNew }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="rawJson">
                                    <ul class="nav nav-tabs" role="tablist" class="mb-3">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#oldJson">Old Values</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#newJson">New Values</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="oldJson">
                                            <pre class="bg-light p-3 rounded border"><code>{{ json_encode($audit->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                                        </div>
                                        <div class="tab-pane fade" id="newJson">
                                            <pre class="bg-light p-3 rounded border"><code>{{ json_encode($audit->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                <i class="bx bx-info-circle me-2"></i>
                                <strong>No Changes Recorded</strong> - This {{ $audit->event }} event has no detailed change data available.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-secondary" role="alert">
                            <i class="bx bx-block me-2"></i>
                            No data changes recorded for this audit entry.
                        </div>
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
