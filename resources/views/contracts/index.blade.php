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
                                <th>Rent Amount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($contracts as $contract)
                                <tr>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $contract->student_id }}</span>
                                    </td>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>B({{ $contract->room->floor->building->name }}), F N.{{ $contract->room->floor->number }}, R N.{{ $contract->room->number }}</span>
                                    </td>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        @if ($contract->status->code==='pending')
                                            <span class="badge bg-label-success me-1">{{ $contract->status->label ?? 'UnKnown' }}</span>
                                        @endif
                                        @if ($contract->status->code==='active')
                                            <span class="badge bg-label-primary me-1">{{ $contract->status->label ?? 'UnKnown' }}</span>
                                        @endif
                                        @if ($contract->status->code==='terminated')
                                            <span class="badge bg-label-secondary me-1">{{ $contract->status->label ?? 'UnKnown' }}</span>
                                        @endif
                                        @if ($contract->status->code==='cancelled')
                                            <span class="badge bg-label-danger me-1">{{ $contract->status->label ?? 'UnKnown' }}</span>
                                        @endif                                    </td>
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
{{--                                     <td>
                                        <span class="badge bg-label-primary me-1">{{ $contract->status->label }}</span>

                                    </td> --}}
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('contracts.index', $contract) }}">
                                                    <i class="icon-base bx bx-show-alt me-1"></i>view</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('contracts.edit', $contract) }}"><i
                                                        class="icon-base bx bx-edit me-1"></i> Edit</a>
                                                <hr class="dropdown-divider">
                                                <form method="POST"
                                                    action="{{ route('contracts.destroy', $contract) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger" type="submit">
                                                        <i class="icon-base bx bx-trash me-1"></i>Delete
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
