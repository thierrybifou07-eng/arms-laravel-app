@extends('layouts.app')

@section('content')
    <div class="col-xxl-4 mb-6 order-0">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">PAYMENT DETAILS</h5>
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
            <div class="card-body pt-4">
                <p><strong>Contract:</strong> #{{ $payment->contract->id }}
                    @php $status = $payment->contract->status->code ?? '' @endphp
                    @if($status === 'overdue')
                        <span class="badge bg-danger">Overdue</span>
                    @elseif($status === 'pending')
                        <span class="badge bg-label-warning">Pending</span>
                    @elseif($status === 'processing')
                        <span class="badge bg-label-info">Processing</span>
                    @elseif($status === 'active')
                        <span class="badge bg-label-info">Active</span>
                    @elseif($status === 'validated')
                        <span class="badge bg-label-success">Validated</span>
                    @elseif($status === 'cancelled')
                        <span class="badge bg-label-danger">Cancelled</span>
                    @endif
                </p>
                <p><strong>Student:</strong> {{ $payment->contract->user->firstname }}
                    {{ $payment->contract->user->lastname }}
                </p>
                <p><strong>Status:</strong>
                    @php $status = $payment->status->code ?? '' @endphp
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
                    @endif
                </p>
                <p><strong>Expected:</strong> {{ number_format($payment->expected_amount) }} FCFA</p>
                <p><strong>Paid:</strong> {{ number_format($payment->paid_amount) }} FCFA</p>
                <p><strong>Due date:</strong> {{ $payment->due_date }}</p>
                <p><strong>Payment Method:</strong>
                    @if (($payment->status->code === 'processing'|| $payment->status->code === 'validated') && $payment->method)
                        <span class="badge bg-label-info">{{ $payment->method->label }}</span>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
@endsection