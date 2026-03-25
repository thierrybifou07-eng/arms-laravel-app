@extends('layouts.app')

@section('content')
<div class="card">
    <h5 class="card-header">Payments</h5>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Contract</th>
                    <th>Student</th>
                    <th>Due Date</th>
                    <th>Expected</th>
                    <th>Paid</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>#{{ $payment->contract->id }}</td>
                    <td>{{ $payment->contract->student->surname }}</td>

                    <td>{{ $payment->due_date?->format('d/m/Y') }}</td>

                    <td>{{ number_format($payment->expected_amount, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($payment->paid_amount, 0, ',', ' ') }} FCFA</td>

                    <td>
                        @php $status = $payment->status->code ?? '' @endphp

                        @if($status === 'pending')
                            <span class="badge bg-label-warning">Pending</span>
                        @elseif($status === 'processing')
                            <span class="badge bg-label-info">Processing</span>
                        @elseif($status === 'validated')
                            <span class="badge bg-label-success">Validated</span>
                        @elseif($status === 'cancelled')
                            <span class="badge bg-label-danger">Cancelled</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-primary">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $payments->links() }}
    </div>
</div>
@endsection