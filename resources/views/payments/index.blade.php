@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">Payments</h5>

            <form method="GET">
                <select name="status" onchange="this.form.submit()" class="form-select">
                    <option value="">All</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="validated" {{ request('status') == 'validated' ? 'selected' : '' }}>Validated</option>
                </select>
            </form>

        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Contract</th>
                        <th>Student</th>
                        <th>Due Date</th>
                        <th>Expected(FCFA)</th>
                        <th>Paid(FCFA)</th>
                        {{-- <th>Tip amount(FCFA)</th> --}}
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="{{ $payment->isOverdue() ? 'table-danger' : '' }}">
                            <td>#{{ $payment->contract->id }}</td>
                            <td>{{ $payment->contract->user->firstname }} {{ $payment->contract->user->lastname }}</td>

                            <td>{{ $payment->due_date?->format('d/m/Y') }}</td>

                            <td>{{ number_format($payment->expected_amount, 0, ',', ' ') }}</td>
                            <td>{{ number_format($payment->paid_amount, 0, ',', ' ') }}</td>
                            {{--                             <td>{{ number_format($payment->tip_amount, 0, ',', ' ') }}</td>
 --}}
                            <td>
                                <a href="{{ route('payments.show.pay', $payment) }}" class="">
                                    @php $status = $payment->status->code ?? '' @endphp

                                    @if ($payment->isOverdue())
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
                                </a>
                            </td>

                            <td>
                                <div class="d-flex flex-row gap-1">
                                    {{-- PAY --}}
                                    @if (
                                        $payment->status->code === 'pending' ||
                                            $payment->status->code === 'cancelled' ||
                                            $payment->status->code === 'overdue')
                                        <a href="{{ route('payments.pay.form', $payment) }}"
                                            class="btn btn-sm btn-primary">
                                            Pay
                                        </a>
                                    @endif
                                    {{-- VALIDATE --}}
                                    @if ($payment->status->code === 'processing')
                                        <form method="POST" action="{{ route('payments.validate', $payment) }}"
                                            class="mt-3">
                                            @csrf
                                            <button class="btn btn-success">Validate</button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
