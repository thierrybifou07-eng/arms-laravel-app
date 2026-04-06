@extends('layouts.app')

@section('content')
    <div class="card mb-6">
        <h5 class="card-header">Update Contract</h5>

        <div class="card-body pt-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                </div>
                </ul>
            @endif


            <form method="POST" action="{{ route('contracts.update', $contract->id) }}">
                @method('PUT')
                @csrf

                <div class="row g-6">
                    <div class="col-md-6">
                        <label class="form-label">Student</label>
                        <input type="text" class="form-control"
                            value="{{ $contract->user->firstname }} {{ $contract->user->lastname }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Room</label>
                        <input type="text" class="form-control"
                            value="Room {{ $contract->room->number }} — {{ $contract->room->floor->building->name }}"
                            readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Billing Period</label>
                        <input type="text" class="form-control" value="{{ $contract->billingPeriod->label }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="start_date">Start date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            value="{{ \Carbon\Carbon::parse($contract->start_date)->format('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="end_date">End date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            value="{{ \Carbon\Carbon::parse($contract->end_date)->format('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn btn-primary me-3">Update Contract</button>
                    <a href="{{ route('contracts.index') }}" class="btn btn-label-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection