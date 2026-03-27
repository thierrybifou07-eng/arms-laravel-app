@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Create a new role</h1>

    <form method="POST" action="{{ route('roles.store') }}" class="card card-body">
        @csrf

        @include('roles._form', ['role' => null, 'permissions' => $permissions])

        <div class="d-flex gap-2">
            <button class="btn btn-primary">Save role</button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
