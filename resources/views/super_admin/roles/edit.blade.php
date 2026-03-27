@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="h4 mb-3">Edit a role</h1>

        <form method="POST" action="{{ route('roles.update', $role) }}" class="card card-body">
            @csrf
            @method('PUT')

            @include('roles._form', ['role' => $role, 'permissions' => $permissions])

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Update role</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
@endsection