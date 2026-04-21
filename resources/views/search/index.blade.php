@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                        <div>
                            <h4 class="mb-1">Search</h4>
                            <p class="text-muted mb-0">
                                @if ($query === '')
                                    Enter a term in the navigation bar to search the application.
                                @else
                                    Results for <strong>"{{ $query }}"</strong>
                                @endif
                            </p>
                        </div>
                        @if ($query !== '')
                            <span class="badge bg-label-primary fs-6">{{ $totalResults }} result(s)</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($query === '')
        <div class="alert alert-info">
            Search across the sections available for your role from the navigation bar.
        </div>
    @elseif ($sections->isEmpty())
        <div class="alert alert-warning">
            No results found for <strong>{{ $query }}</strong>.
        </div>
    @else
        <div class="row">
            @foreach ($sections as $section)
                <div class="col-12 col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="icon-base bx {{ $section['icon'] }} fs-4"></i>
                                <h5 class="mb-0">{{ $section['title'] }}</h5>
                            </div>
                            <span class="badge bg-label-secondary">{{ count($section['items']) }}</span>
                        </div>
                        <div class="list-group list-group-flush">
                            @foreach ($section['items'] as $item)
                                <a href="{{ $item['url'] }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $item['title'] }}</div>
                                            <div class="small text-muted">{{ $item['description'] }}</div>
                                        </div>
                                        @if (!empty($item['meta']))
                                            <span class="badge bg-label-primary">{{ $item['meta'] }}</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
