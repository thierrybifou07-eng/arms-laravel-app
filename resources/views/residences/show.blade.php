@extends('layouts.app')

@section('content')
    <div class="col-xxl-12 my-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Residence Details</h5>
                <a href="{{ route('residences.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Name:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $residence->name }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>City:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $residence->city }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Address:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $residence->address }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Capacity:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $residence->capacity }} building(s)</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Status:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">
                            <span class="badge bg-label-primary">{{ $residence->status->label ?? 'Unknown' }}</span>
                        </p>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label"><strong>Created Date:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $residence->created_at?->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label"><strong>Updated Date:</strong></label>
                    <div class="col-sm-10">
                        <p class="form-control-plaintext">{{ $residence->updated_at?->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="row justify-content-end mt-4">
                    <div class="col-sm-10">
                        <a href="{{ route('residences.edit', $residence) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('residences.buildings.index', $residence) }}" class="btn btn-info">View Buildings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection