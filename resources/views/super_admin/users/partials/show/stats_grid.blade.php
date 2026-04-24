<div class="row">
    @foreach ($stats as $stat)
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <small class="text-muted d-block mb-1">{{ $stat['label'] }}</small>
                            <h5 class="mb-0">{{ $stat['value'] }}</h5>
                        </div>
                        <span class="avatar avatar-sm bg-label-primary rounded">
                            <i class="bx {{ $stat['icon'] ?? 'bx-bar-chart-alt-2' }}"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
