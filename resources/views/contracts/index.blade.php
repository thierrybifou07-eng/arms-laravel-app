@extends('layouts.app')
@section('content')
    <div class="col-xxl-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card my-5">

            @if ($contracts->count() > 0)
                <div class="table-responsive table-hover text-nowrap">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Students</th>
                                <th>Rooms</th>
                                <th>Status</th>
                                <th>Billing Periods</th>
                                <th>Rent Amount(FCFA)</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($contracts as $contract)
                                <tr>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $contract->student->surname }} {{ $contract->student->given_name }}</span>
                                    </td>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>({{ $contract->room->floor->building->name }})/Floor
                                            {{ $contract->room->floor->number }}/Room {{ $contract->room->number }}</span>
                                    </td>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        @switch($contract->status->code)
                                        @case('pending')
                                        <span class="badge bg-label-warning">{{ $contract->status->label }}</span>
                                        @break
                                        @case('active')
                                        <span class="badge bg-label-success">{{ $contract->status->label }}</span>
                                        @break
                                        @case('overdue')
                                        <span class="badge bg-label-danger">{{ $contract->status->label }}</span>
                                        @break
                                        @case('expired')
                                        <span class="badge bg-label-secondary">{{ $contract->status->label }}</span>
                                        @break
                                        @case('archived')
                                        <span class="badge bg-label-dark">{{ $contract->status->label }}</span>
                                        @break
                                        @default
                                        <span class="badge bg-label-info">{{ $contract->status->label ?? 'Unknown' }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        {{ $contract->billingPeriod->label }}
                                    </td>
                                    <td>
                                        {{ $contract->rent_amount }}
                                    </td>
                                    <td>
                                        {{ $contract->start_date }}
                                    </td>
                                    <td>
                                        {{ $contract->end_date }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('contracts.show', $contract) }}">
                                                    <i class="icon-base bx bx-show-alt me-1"></i>view</a>
                                                <a class="dropdown-item" href="{{ route('contracts.edit', $contract) }}"><i
                                                        class="icon-base bx bx-edit me-1"></i> Edit</a>
                                                <hr class="dropdown-divider">
                                                <form method="POST" action="{{ route('contracts.archive', $contract) }}">
                                                    @csrf
                                                    <button class="dropdown-item text-danger" type="submit">
                                                        <i class="icon-base bx bx-trash me-1"></i>Archived
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="demo-inline-spacing mx-5">
                        <a class="btn rounded-pill btn-primary" href="{{ route('contracts.create') }}">
                            No contract found, create one. </a>
                    </div>
                </div>
            @endif

        </div>
        @if ($contracts->count() > 0)
            <div class="demo-inline-spacing mx-5">
                <a href="{{ route('contracts.create') }}" class="btn rounded-pill btn-primary">New contract</a>
            </div>
        @endif
    </div>

@endsection