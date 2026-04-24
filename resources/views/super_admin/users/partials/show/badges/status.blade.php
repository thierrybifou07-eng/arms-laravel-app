@php
    $statusCode = $status?->code;
    $statusLabel = $status?->label ?? 'N/A';
    $statusClass = match ($statusCode) {
        'active' => 'bg-success',
        'pending' => 'bg-warning',
        'disabled' => 'bg-danger',
        default => 'bg-secondary',
    };
@endphp

<span class="badge {{ $statusClass }}">
    {{ $statusLabel }}
</span>
