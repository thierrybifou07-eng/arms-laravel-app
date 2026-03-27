@extends('layouts.app')

@section('content')
    <div class="card mb-6">

        <h5 class="card-header">PAYMENT DETAILS</h5>
        <div class="card-body pt-4">
<p><strong>Contract:</strong> #{{ $payment->contract->id }}</p>
        <p><strong>Student:</strong> {{ $payment->contract->student->surname }}</p>
        <p><strong>Status:</strong>                                 @php $status = $payment->status->code ?? '' @endphp

                                @if($payment->isOverdue())
                                    <span class="badge bg-danger">Overdue</span>
                                @elseif($status === 'pending')
                                    <span class="badge bg-label-warning">Pending</span>
                                @elseif($status === 'processing')
                                    <span class="badge bg-label-info">Processing</span>
                                @elseif($status === 'validated')
                                    <span class="badge bg-label-success">Validated</span>
                                @elseif($status === 'cancelled')
                                    <span class="badge bg-label-danger">Cancelled</span>
                                @endif</p>
        <p><strong>Expected:</strong> {{ number_format($payment->expected_amount) }} FCFA</p>
        <p><strong>Paid:</strong> {{ number_format($payment->paid_amount) }} FCFA</p>
        <p><strong>Due date:</strong> {{ $payment->due_date }}</p>
        </div>
    </div>
@endsection