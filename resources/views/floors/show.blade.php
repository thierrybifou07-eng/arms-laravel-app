@extends('layouts.app')

@section('content')
    <div class="col-xxl-12 my-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Floor Details</h5>
                <a href="{{ route('buildings.floors.index', $building) }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Building:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $building->name }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Floor Number:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $floor->number }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Capacity:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $floor->capacity }} room(s)</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Status:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">
                            <span class="badge bg-label-primary">{{ $floor->status->label ?? 'Unknown' }}</span>
                        </p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Created Date:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $floor->created_at?->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label"><strong>Updated Date:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $floor->updated_at?->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-start mt-4">
            <div class="col-sm-10">
                <a href="{{ route('buildings.floors.edit', [$building, $floor]) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('floors.rooms.index', $floor) }}" class="btn btn-info">View Rooms</a>
            </div>
        </div>
    </div>
@endsection
