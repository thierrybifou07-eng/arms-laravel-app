@include('super_admin.users.partials.show.stats_grid', ['stats' => $roleInsights['stats'] ?? []])

<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bx bx-buildings me-2"></i>Portfolio Summary
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Rooms in scope</small>
                    <h4 class="mb-0">{{ $roleInsights['residence_summary']['rooms_total'] ?? 0 }}</h4>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Busy rooms</small>
                    <h4 class="mb-0">{{ $roleInsights['residence_summary']['rooms_busy'] ?? 0 }}</h4>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Students with active contracts</small>
                    <h4 class="mb-0">{{ $roleInsights['residence_summary']['active_students'] ?? 0 }}</h4>
                </div>
                <div>
                    <small class="text-muted d-block">Validated this month</small>
                    <h4 class="mb-0">
                        {{ number_format($roleInsights['residence_summary']['validated_payments_this_month'] ?? 0, 0, ',', ' ') }}
                        FCFA
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bx bx-map-pin me-2"></i>Managed Residences
                </h6>
            </div>
            <div class="card-body">
                @if (!empty($roleInsights['managed_residences']) && $roleInsights['managed_residences']->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Residence</th>
                                    <th>City</th>
                                    <th>Capacity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roleInsights['managed_residences'] as $residence)
                                    <tr>
                                        <td>
                                            <a href="{{ route('residences.show', $residence) }}" class="text-primary">
                                                {{ $residence->name }}
                                            </a>
                                        </td>
                                        <td>{{ $residence->city ?? 'N/A' }}</td>
                                        <td>{{ $residence->capacity ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-label-secondary">
                                                {{ $residence->status?->label ?? 'No status' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-light mb-0">
                        <i class="bx bx-info-circle me-2"></i>No residence is currently assigned to this admin.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="bx bx-file-blank me-2"></i>Recent Managed Contracts
        </h6>
    </div>
    <div class="card-body">
        @if (!empty($roleInsights['recent_contracts']) && $roleInsights['recent_contracts']->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Contract</th>
                            <th>Student</th>
                            <th>Room</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roleInsights['recent_contracts'] as $contract)
                            <tr>
                                <td>
                                    <a href="{{ route('contracts.show', $contract) }}" class="text-primary">
                                        #{{ $contract->id }}
                                    </a>
                                </td>
                                <td>{{ $contract->user?->firstname ?? 'N/A' }} {{ $contract->user?->lastname ?? '' }}</td>
                                <td>
                                    {{ $contract->room?->floor?->building?->residence?->name ?? 'N/A' }}
                                    / F{{ $contract->room?->floor?->number ?? 'N/A' }}
                                    / R{{ $contract->room?->number ?? 'N/A' }}
                                </td>
                                <td>
                                    @php $statusCode = $contract->status?->code; @endphp
                                    @if ($statusCode === 'active')
                                        <span class="badge bg-success">{{ $contract->status->label }}</span>
                                    @elseif ($statusCode === 'pending')
                                        <span class="badge bg-warning">{{ $contract->status->label }}</span>
                                    @elseif ($statusCode === 'overdue')
                                        <span class="badge bg-danger">{{ $contract->status->label }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $contract->status?->label ?? 'Unknown' }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-light mb-0">
                <i class="bx bx-info-circle me-2"></i>No managed contract activity was found yet.
            </div>
        @endif
    </div>
</div>
