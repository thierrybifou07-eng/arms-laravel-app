@include('super_admin.users.partials.show.stats_grid', ['stats' => $roleInsights['stats'] ?? []])

<div class="card mb-4">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="bx bx-shield-quarter me-2"></i>Recent Audit Activity
        </h6>
    </div>
    <div class="card-body">
        @if (!empty($roleInsights['recent_audits']) && $roleInsights['recent_audits']->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Event</th>
                            <th>Model</th>
                            <th>When</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roleInsights['recent_audits'] as $audit)
                            <tr>
                                <td><span class="badge bg-label-primary">{{ $audit->event_label }}</span></td>
                                <td>{{ $audit->model_name }}</td>
                                <td><small class="text-muted">{{ $audit->created_at?->format('M d, Y H:i') }}</small></td>
                                <td class="text-end">
                                    <a href="{{ route('audits.show', $audit) }}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-light mb-0">
                <i class="bx bx-info-circle me-2"></i>No audit activity was found for this account yet.
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="bx bx-building-house me-2"></i>Assigned Residences
        </h6>
    </div>
    <div class="card-body">
        @if (!empty($roleInsights['managed_residences']) && $roleInsights['managed_residences']->isNotEmpty())
            <div class="row">
                @foreach ($roleInsights['managed_residences'] as $residence)
                    <div class="col-md-6 mb-3">
                        <div class="border rounded p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <h6 class="mb-1">{{ $residence->name }}</h6>
                                    <p class="text-muted mb-2">{{ $residence->city ?? 'City not defined' }}</p>
                                </div>
                                <span class="badge bg-label-secondary">
                                    {{ $residence->status?->label ?? 'No status' }}
                                </span>
                            </div>
                            <a href="{{ route('residences.show', $residence) }}" class="btn btn-sm btn-outline-primary">
                                Open residence
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-light mb-0">
                <i class="bx bx-info-circle me-2"></i>No residence is currently linked to this super admin account.
            </div>
        @endif
    </div>
</div>
