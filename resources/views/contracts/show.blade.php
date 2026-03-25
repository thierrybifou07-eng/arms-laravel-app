@extends('layouts.app')

@section('content')
    <div class="row g-5 ">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header">
                    <h5>Contract Details</h5>
                </div>

                <div class="card-body">
                    <p><strong>Student:</strong> {{ $contract->student->surname }} {{ $contract->student->given_name }}</p>
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
                            <thead>
                                <tr>
                                    <th>Due date</th>
                                    <th>Expected</th>
                                    <th>Paid</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contract->payments as $payment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') }}</td>
                                        <td>{{ number_format($payment->expected_amount, 0, ',', ' ') }} FCFA</td>
                                        <td>{{ number_format($payment->paid_amount, 0, ',', ' ') }} FCFA</td>
                                        <td>{{ $payment->status->label ?? 'N/A' }}</td>
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