@extends('layouts.app')

@section('content')
    <div class="col-xxl-12 my-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Building Details</h5>
                <a href="{{ route('residences.buildings.index', $residence) }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Residence:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $residence->name }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Name:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $building->name }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Address:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $building->address ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Capacity:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $building->capacity }} floor(s)</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Status:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">
                            <span class="badge bg-label-primary">{{ $building->status->label ?? 'Unknown' }}</span>
                        </p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Created Date:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $building->created_at?->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label"><strong>Updated Date:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $building->updated_at?->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="row justify-content-end mt-4">
                    <div class="col-sm-10">
                        <a href="{{ route('residences.buildings.edit', [$residence, $building]) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('buildings.floors.index', $building) }}" class="btn btn-info">View Floors</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
