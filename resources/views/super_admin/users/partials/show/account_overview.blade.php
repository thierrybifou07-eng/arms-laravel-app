<div class="card mb-4">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="bx bx-history me-2"></i>Account Overview
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 col-6 mb-3">
                <div class="text-center p-3 bg-light rounded h-100">
                    <p class="text-muted small mb-1">Current Status</p>
                    <div class="mb-0">
                        @include('super_admin.users.partials.show.badges.status', ['status' => $user->userStatus])
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="text-center p-3 bg-light rounded h-100">
                    <p class="text-muted small mb-1">Email</p>
                    <h6 class="mb-0">{{ $user->email_verified_at ? 'Verified' : 'Pending' }}</h6>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="text-center p-3 bg-light rounded h-100">
                    <p class="text-muted small mb-1">Contracts</p>
                    <h5 class="mb-0">{{ $user->contracts->count() }}</h5>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="text-center p-3 bg-light rounded h-100">
                    <p class="text-muted small mb-1">Residences</p>
                    <h5 class="mb-0">{{ $user->residences->count() }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
