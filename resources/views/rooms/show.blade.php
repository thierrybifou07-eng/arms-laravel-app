@extends('layouts.app')

@section('content')
    <div class="col-xxl-12 my-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Room Details</h5>
                <a href="{{ route('floors.rooms.index', $floor) }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Floor:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">Floor {{ $floor->number }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Room Number:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $room->number }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Capacity:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $room->capacity }} student(s)</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Rent (FCFA):</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ number_format($room->rent, 0, ',', ' ') }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Status:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">
                            <span class="badge bg-label-primary">{{ $room->status->label ?? 'Unknown' }}</span>
                        </p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Created Date:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $room->created_at?->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label"><strong>Updated Date:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $room->updated_at?->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-end mt-4">
            <div class="col-sm-10">
                <a href="{{ route('floors.rooms.edit', [$floor, $room]) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
@endsection
