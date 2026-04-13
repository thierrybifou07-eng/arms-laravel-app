@extends('layouts.app')

@section('content')
    <div class="row g-5 ">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header">
                    <h5>Contract Details</h5>
                </div>

                <div class="card-body">
                    <p><strong>Student:</strong> {{ $contract->user->firstname }} {{ $contract->user->lastname }}</p>
                    <p><strong>Email:</strong> {{ $contract->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $contract->user->phone }}</p>
                    <p><strong>Room:</strong> B({{ $contract->room->floor->building->name }}), Floor
                        {{ $contract->room->floor->number }}, Room {{ $contract->room->number }}
                    </p>
                    <p><strong>Status:</strong> {{ $contract->status->label }}</p>
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
                            <thead class="table-dark">
                                <tr>
                                    <th>Due date</th>
                                    <th>Expected(FCFA)</th>
                                    <th>Other(FCFA)</th>
                                    <th>Paid(FCFA)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contract->payments as $payment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') }}</td>
                                        <td>{{ number_format($payment->expected_amount, 0, ',', ' ') }}</td>
                                        <td>{{ number_format($payment->tip_amount, 0, ',', ' ') }}</td>
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
                                            <span class="badge bg-label-secondary">{{ $payment->status->label ?? 'Unknown'
                                                }}</span>
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