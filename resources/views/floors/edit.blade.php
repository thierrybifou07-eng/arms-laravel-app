@extends('layouts.app')
@section('content')
    <div class="col-xxl-12 my-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit Floor</h5>
                <small class="text-body-secondary float-end">Update floor information</small>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body">
                <form method="POST" action="{{ route('buildings.floors.update', [$building, $floor]) }}">
                    @csrf
                    @method('PUT')
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="number">Number</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-message2" class="input-group-text"><i
                                        class="icon-base bx bx-box"></i></span>
                                <input type="number" name="number" class="form-control" id="basic-icon-default-fullname"
                                    placeholder="Enter the floor's number" aria-label="Enter the floor's number"
                                    aria-describedby="basic-icon-default-fullname2" value="{{ old('number', $floor->number) }}">
                            </div>
                            @error('number')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="capacity">Capacity</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-envelope"></i></span>
                                <input type="number" name="capacity" value="{{ old('capacity', $floor->capacity) }}"
                                    id="basic-icon-default-email" class="form-control"
                                    placeholder="Enter the floor's capacity" aria-label="Enter the floor's capacity"
                                    aria-describedby="basic-icon-default-email2">
                                <span id="basic-icon-default-email2" class="input-group-text">room(s)</span>
                            </div>
                            <div class="form-text">You can only use numbers</div>
                            @error('capacity')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="floor_status_id">Status</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-envelope"></i></span>
                                <select name="floor_status_id" class="form-select" id="exampleFormControlSelect1"
                                    aria-label="Default select example">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ old('floor_status_id', $floor->floor_status_id) == $status->id ? 'selected' : '' }}>
                                            {{ $status->label ?? $status->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-text">What's the status of the floor</div>
                            @error('floor_status_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('buildings.floors.index', $building) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="demo-inline-spacing mx-5">
            <a href="{{ route('buildings.floors.index',$building) }}" class="btn rounded-pill btn-primary">Back</a>
        </div>
    </div>
@endsection
