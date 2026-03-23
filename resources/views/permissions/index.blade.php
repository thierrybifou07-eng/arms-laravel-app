@extends('layouts.app')
@section('content')
    <div class="card m-5">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($permissions->count() > 0)
            <div class="table-responsive text-nowrap table-hover">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Label</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($permissions as $permission)
                            <tr>
                                <td class="text-center"><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                    <span>{{ $permission->label }}</span>
                                </td>
                                <td> {{ $permission->created_at }}
                                </td>
                                <td>
                                    {{ $permission->updated_at }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <h5>No permissions found</h5>
            </div>
        @endif
    </div>
@endsection