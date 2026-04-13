@extends('layouts.app')

@section('content')
    <div class="row g-5 ">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Contract Details</h5>
                    <a href="{{ route('contracts.index') }}" class="btn btn-sm btn-secondary">Back</a>
                </div>

                <div class="card-body">
                    <p><strong>Student:</strong> {{ $contract->user->firstname }} {{ $contract->user->lastname }}</p>
                    <p><strong>Email:</strong> {{ $contract->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $contract->user->phone }}</p>
                    <p><strong>Residence:</strong> {{ $contract->room->floor->building->residence->name }}
                    </p>
                    <p><strong>Building:</strong> {{ $contract->room->floor->building->name }}
                    </p>
                    <p><strong>Room:</strong> {{ $contract->room->number }} at the floor {{ $contract->room->floor->number }} 
                    </p>
                    <p><strong>Status:</strong>

                        @switch($contract->status->code ?? '')
                            @case('pending')
                                <span class="badge bg-label-info">{{ $contract->status->label ?? 'Pending' }}</span>
                            @break

                            @case('active')
                                <span class="badge bg-label-success">{{ $contract->status->label ?? 'Active' }}</span>
                            @break

                            @case('overdue')
                                <span class="badge bg-label-warning">{{ $contract->status->label ?? 'Overdue' }}</span>
                            @break

                            @case('archived')
                                <span class="badge bg-label-secondary">{{ $contract->status->label ?? 'Archived' }}</span>
                            @break

                            @case('expired')
                                <span class="badge bg-label-secondary">{{ $contract->status->label ?? 'Expired' }}</span>
                            @break

                            @case('cancelled')
                                <span class="badge bg-label-secondary">{{ $contract->status->label ?? 'Cancelled' }}</span>
                            @break

                            @default
                                <span class="badge bg-label-light">Unknown</span>
                        @endswitch

                    </p>
                    <p><strong>Billing period:</strong> {{ $contract->billingPeriod->label }}</p>
                    <p><strong>Rent amount:</strong> {{ number_format($contract->rent_amount, 0, ',', ' ') }} FCFA</p>
                    <p><strong>Start date:</strong> {{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') }}</p>
                    <p><strong>End date:</strong> {{ \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header">
                    <h5>Related Payments</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Due date</th>
                                    <th>Expected(FCFA)</th>
                                    <th>Paid(FCFA)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contract->payments as $payment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') }}</td>
                                        <td>{{ number_format($payment->expected_amount, 0, ',', ' ') }}</td>
                                        <td>{{ number_format($payment->paid_amount, 0, ',', ' ') }}</td>
                                        <td> @switch($payment->status->code)
                                                @case('pending')
                                                    <span class="badge bg-label-warning">{{ $payment->status->label }}</span>
                                                @break

                                                @case('processing')
                                                    <span class="badge bg-label-primary">{{ $payment->status->label }}</span>
                                                @break

                                                @case('overdue')
                                                    <span class="badge bg-label-danger">{{ $payment->status->label }}</span>
                                                @break

                                                @case('paid')
                                                    <span class="badge bg-label-info">{{ $payment->status->label }}</span>
                                                @break

                                                @case('validated')
                                                    <span class="badge bg-label-success">{{ $payment->status->label }}</span>
                                                @break

                                                @case('cancelled')
                                                    <span
                                                        class="badge bg-label-secondary">{{ $payment->status->label ?? 'Unknown' }}</span>
                                                @break
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
