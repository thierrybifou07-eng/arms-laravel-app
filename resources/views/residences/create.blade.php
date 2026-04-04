@extends('layouts.app')

@section('content')
    <div class="col-xxl-12 my-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Create a new residence</h5>
                <small class="text-body-secondary float-end">Merged input group</small>
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
                <form method="POST" action="{{ route('residences.store') }}">
                    @csrf
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name">Name</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-message2" class="input-group-text"><i
                                        class="icon-base bx bx-box"></i></span>
                                <input type="text" name="name" class="form-control" id="basic-icon-default-fullname"
                                    placeholder="Enter the residence's name" aria-label="Enter the residence's name"
                                    aria-describedby="basic-icon-default-fullname2" value="{{old('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="city">City</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-company2" class="input-group-text"><i
                                        class="icon-base bx bx-buildings"></i></span>
                                <input type="text" name="city" value="{{old('city') }}" id="basic-icon-default-company" class="form-control"
                                    placeholder="Ex.Douala" aria-label="Ex.Douala"
                                    aria-describedby="basic-icon-default-company2">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="address">Address</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-company2" class="input-group-text"><i
                                        class="icon-base bx bx-buildings"></i></span>
                                <input type="text" name="address" id="basic-icon-default-company" class="form-control"
                                    placeholder="Ex.PK-17 Station Neptune" value="{{old('address') }}" aria-label="Ex.PK-17 Station Neptune"
                                    aria-describedby="basic-icon-default-company2">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="capacity">Capacity</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-envelope"></i></span>
                                <input type="number" name="capacity" value="{{old('capacity') }}" id="basic-icon-default-email" class="form-control"
                                    placeholder="Enter the residence's capacity" aria-label="Enter the residence's capacity"
                                    aria-describedby="basic-icon-default-email2">
                                <span id="basic-icon-default-email2" class="input-group-text">building(s)</span>
                            </div>
                            <div class="form-text">You can only use numbers</div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="residence_status_id">Status</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-envelope"></i></span>
                                <select name="residence_status_id" class="form-select" id="exampleFormControlSelect1"
                                    aria-label="Default select example">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">
                                            {{ $status->label ?? $status->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-text">What's the status of the residence</div>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
