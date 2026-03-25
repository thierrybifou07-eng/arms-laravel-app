@extends('layouts.app')

@section('content')
    <div class="row g-5 ">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header">
                    <h5>Contract Details</h5>
                </div>

                <div class="card-body">

                    <p><strong>Student:</strong>
                        {{ $contract->student->surname }} {{ $contract->student->given_name }}
                    </p>

                    <p><strong>Residence:</strong>
                        {{ $contract->room->floor->building->residence->name }}
                    </p>
                    <p><strong>Building:</strong>
                        {{ $contract->room->floor->building->name }}
                    </p>
                    <p><strong>Floor:</strong>
                        {{ $contract->room->floor->number }}
                    </p>
                    <p><strong>Room:</strong>
                        {{ $contract->room->number }}
                    </p>

                    <p><strong>Status:</strong>
                        {{ $contract->status->label }}
                    </p>

                    <p><strong>Billing Period:</strong>
                        {{ $contract->billingPeriod->label }}
                    </p>

                    <p><strong>Start:</strong> {{ $contract->start_date }}</p>
                    <p><strong>End:</strong> {{ $contract->end_date }}</p>

                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header">
                    <h5>Payments</h5>
                </div>

                <div class="card-body">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Due Date</th>
                                <th>Expected</th>
                                <th>Paid</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($contract->payments as $payment)
                                <tr>
                                    <td>{{ $payment->due_date }}</td>
                                    <td>{{ $payment->expected_amount }}</td>
                                    <td>{{ $payment->paid_amount }}</td>
                                    <td>{{ $payment->status->label }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection