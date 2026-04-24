@extends('layouts.app')

@section('content')
    <!-- Welcome Card -->
    <div class="card mb-4">
        <div class="d-flex align-items-start row">
            <div class="col-sm-7">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-3">Welcome {{ Auth::user()->firstname }}
                        {{ Auth::user()->lastname }}! 🎉</h5>
                    <p class="mb-3">You are connected as
                        <strong>{{ Auth::user()->roles->first()->label }}</strong>
                    </p>
                    <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">
                        <i class="icon-base bx bx-user me-1"></i> See Profile
                    </a>
                </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-6">
                    <img src="{{ asset('admin-template/assets/img/illustrations/man-with-laptop.png') }}" height="175"
                        alt="Welcome">
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="mb-0">{{ $dashboardData['totalStudents'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Total Students
                                <span class="badge bg-warning ms-2">{{ $dashboardData['pendingStudents'] ?? 0 }}</span>
                                <span class="badge bg-success ms-2">{{ $dashboardData['activeStudents'] ?? 0 }}</span>
                            </p>
                        </div>
                        <i class="icon-base bx bx-user-circle text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="mb-0">{{ $dashboardData['totalContracts'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Contracts <span
                                    class="badge bg-success ms-2">{{ $dashboardData['activeContracts'] ?? 0 }}</span></p>
                        </div>
                        <i class="icon-base bx bx-receipt text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="mb-0">{{ $dashboardData['totalPayments'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Payments
                                <span class="badge bg-success ms-2">{{ $dashboardData['validatedPayments'] ?? 0 }}</span>
                            </p>
                        </div>
                        <i class="icon-base bx bx-money text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="mb-0">{{ count($dashboardData['residenceStats'] ?? []) }}</h3>
                            <p class="text-muted mb-0">Managed Residences</p>
                        </div>
                        <i class="icon-base bx bx-building text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-1">Occupancy Rate</small>
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="mb-0">{{ $dashboardData['occupancyRate'] ?? 0 }}%</h3>
                        <i class="icon-base bx bx-bed text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <div class="progress mt-3" style="height: 8px;">
                        <div class="progress-bar" style="width: {{ $dashboardData['occupancyRate'] ?? 0 }}%;"
                            role="progressbar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-1">Busy Rooms</small>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="mb-1">{{ $dashboardData['roomStats']['busy'] ?? 0 }}</h3>
                            <p><span class="badge bg-label-secondary m-1">{{ $dashboardData['roomStats']['available'] ?? 0 }}
                                    available</span>
                                <span class="badge bg-label-secondary m-1">{{ $dashboardData['roomStats']['total'] ?? 0 }}
                                    total</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-1">This Month Collected</small>
                    <h3 class="mb-0">{{ number_format($dashboardData['validatedPaymentsThisMonth'] ?? 0, 0, ',', ' ') }}
                    </h3>
                    <small class="text-muted">FCFA validated</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-1">Overdue Payments</small>
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="mb-0">{{ $dashboardData['overduePayments'] ?? 0 }}</h3>
                        <i class="icon-base bx bx-error-circle text-danger" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Contracts Distribution -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Contracts Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="contractsChart" style="height: 300px;"></div>
                    <div class="mt-3">
                        <div class="row text-center">
                            <div class="col-6 col-md-4">
                                <small class="text-muted d-block">Pending</small>
                                <h6>{{ $dashboardData['contractsByStatus']['pending'] ?? 0 }}</h6>
                            </div>
                            <div class="col-6 col-md-4">
                                <small class="text-muted d-block">Active</small>
                                <h6>{{ $dashboardData['contractsByStatus']['active'] ?? 0 }}</h6>
                            </div>
                            <div class="col-6 col-md-4">
                                <small class="text-muted d-block">Overdue</small>
                                <h6>{{ $dashboardData['contractsByStatus']['overdue'] ?? 0 }}</h6>
                            </div>
                            <div class="col-6 col-md-4">
                                <small class="text-muted d-block">Expired</small>
                                <h6>{{ $dashboardData['contractsByStatus']['expired'] ?? 0 }}</h6>
                            </div>
                            <div class="col-6 col-md-4">
                                <small class="text-muted d-block">Archived</small>
                                <h6>{{ $dashboardData['contractsByStatus']['archived'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Distribution -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Payments Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="paymentsChart" style="height: 300px;"></div>
                    <div class="mt-3">
                        <div class="row text-center">
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block">Pending</small>
                                <h6>{{ $dashboardData['paymentsByStatus']['pending'] ?? 0 }}</h6>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block">Processing</small>
                                <h6>{{ $dashboardData['paymentsByStatus']['processing'] ?? 0 }}</h6>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block">Validated</small>
                                <h6>{{ $dashboardData['paymentsByStatus']['validated'] ?? 0 }}</h6>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block">Cancelled</small>
                                <h6>{{ $dashboardData['paymentsByStatus']['cancelled'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Residence Statistics -->
    @if (!empty($dashboardData['residenceStats']))
        <div class="row">
            @foreach ($dashboardData['residenceStats'] as $stat)
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="icon-base bx bx-building me-2"></i>{{ $stat['residence']->name }} - Monthly
                                Revenue
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div id="residence-chart-{{ $stat['residence']->id }}" style="height: 350px;"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="text-muted mb-3">12-Month Summary</h6>
                                            <div class="mb-3">
                                                <small class="text-muted d-block">Total Income (12 months)</small>
                                                <h4 class="text-success">
                                                    {{ number_format($stat['totalAmount'], 0, ',', ' ') }} FCFA</h4>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Average Monthly</small>
                                                <h4 class="text-info">
                                                    {{ number_format($stat['totalAmount'] / 12, 0, ',', ' ') }} FCFA</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Recent Data -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Recent Payments</h5>
                    <a href="{{ route('payments.index') }}" class="btn btn-sm btn-primary">See all</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="table-dark">
                                <th>ID</th>
                                <th>Student</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardData['recentPayments'] ?? [] as $payment)
                                <tr>
                                    <td>#{{ $payment->id }}</td>
                                    <td>{{ $payment->contract?->user?->firstname ?? 'N/A' }}
                                        {{ $payment->contract?->user?->lastname ?? '' }}</td>
                                    <td>{{ number_format($payment->expected_amount ?? 0, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        @php $status = $payment->status->code ?? '' @endphp

                                        @if ($payment->isOverdue())
                                            <span class="badge bg-danger">Overdue</span>
                                        @elseif($status === 'pending')
                                            <span class="badge bg-label-warning">Pending</span>
                                        @elseif($status === 'processing')
                                            <span class="badge bg-label-info">Processing</span>
                                        @elseif($status === 'validated')
                                            <span class="badge bg-label-success">Validated</span>
                                        @elseif($status === 'cancelled')
                                            <span class="badge bg-label-danger">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No payment</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Recent Contracts</h5>
                    <a href="{{ route('contracts.index') }}" class="btn btn-sm btn-primary">See all</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="table-dark">
                                <th>Student</th>
                                <th>Room</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardData['recentContracts'] ?? [] as $contract)
                                <tr>
                                    <td>{{ $contract->user?->firstname ?? 'N/A' }} {{ $contract->user?->lastname ?? '' }}
                                    </td>
                                    <td>{{ $contract->room?->floor?->building?->name ?? 'N/A' }}/F{{ $contract->room?->floor?->number ?? 'N/A' }}/R{{ $contract->room?->number ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @php $status = $contract->status->code ?? '' @endphp
                                        @if ($status === 'pending')
                                            <span class="badge bg-label-warning">Pending</span>
                                        @elseif($status === 'active')
                                            <span class="badge bg-label-success">Active</span>
                                        @elseif($status === 'overdue')
                                            <span class="badge bg-danger">Overdue</span>
                                        @elseif($status === 'expired')
                                            <span class="badge bg-label-secondary">Expired</span>
                                        @elseif($status === 'archived')
                                            <span class="badge bg-label-dark">Archived</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No contract</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script>
        <script>
            // Contracts Pie Chart
            const contractColors = ['#FF9800', '#4CAF50', '#F44336', '#2196F3', '#757575'];
            const contractOptions = {
                chart: {
                    type: 'donut',
                    height: 300,
                },
                series: [
                    {{ $dashboardData['contractsByStatus']['pending'] ?? 0 }},
                    {{ $dashboardData['contractsByStatus']['active'] ?? 0 }},
                    {{ $dashboardData['contractsByStatus']['overdue'] ?? 0 }},
                    {{ $dashboardData['contractsByStatus']['expired'] ?? 0 }},
                    {{ $dashboardData['contractsByStatus']['archived'] ?? 0 }},
                ],
                labels: ['Pending', 'Active', 'Overdue', 'Expired', 'Archived'],
                colors: contractColors,
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            const contractChart = new ApexCharts(
                document.querySelector("#contractsChart"),
                contractOptions
            );
            contractChart.render();

            // Payments Pie Chart
            const paymentColors = ['#FF9800', '#FFC107', '#4CAF50', '#F44336'];
            const paymentOptions = {
                chart: {
                    type: 'donut',
                    height: 300,
                },
                series: [
                    {{ $dashboardData['paymentsByStatus']['pending'] ?? 0 }},
                    {{ $dashboardData['paymentsByStatus']['processing'] ?? 0 }},
                    {{ $dashboardData['paymentsByStatus']['validated'] ?? 0 }},
                    {{ $dashboardData['paymentsByStatus']['cancelled'] ?? 0 }},
                ],
                labels: ['Pending', 'Processing', 'Validated', 'Cancelled'],
                colors: paymentColors,
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            const paymentChart = new ApexCharts(
                document.querySelector("#paymentsChart"),
                paymentOptions
            );
            paymentChart.render();

            // Residence Charts (Line Charts for Monthly Data)
            @foreach ($dashboardData['residenceStats'] ?? [] as $stat)
                const residenceData_{{ $stat['residence']->id }} = {
                    months: [
                        @foreach ($stat['monthlyData'] as $month)
                            '{{ $month['month'] }}',
                        @endforeach
                    ],
                    amounts: [
                        @foreach ($stat['monthlyData'] as $month)
                            {{ $month['amount'] }},
                        @endforeach
                    ]
                };

                const residenceOptions_{{ $stat['residence']->id }} = {
                    chart: {
                        type: 'line',
                        height: 350,
                        toolbar: {
                            show: true
                        }
                    },
                    series: [{
                        name: 'Revenue (FCFA)',
                        data: residenceData_{{ $stat['residence']->id }}.amounts
                    }],
                    xaxis: {
                        categories: residenceData_{{ $stat['residence']->id }}.months,
                        title: {
                            text: 'Month'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Amount (FCFA)'
                        },
                        labels: {
                            formatter: function(value) {
                                return value.toLocaleString('fr-FR', {
                                    maximumFractionDigits: 0
                                });
                            }
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    colors: ['#4CAF50'],
                    grid: {
                        borderColor: '#e0e0e0'
                    }
                };

                const residenceChart_{{ $stat['residence']->id }} = new ApexCharts(
                    document.querySelector("#residence-chart-{{ $stat['residence']->id }}"),
                    residenceOptions_{{ $stat['residence']->id }}
                );
                residenceChart_{{ $stat['residence']->id }}.render();
            @endforeach
        </script>
    @endpush
@endsection
<div class="d-flex align-items-start row">
    <div class="col-sm-7">
        <div class="card-body">
            <h5 class="card-title text-primary mb-3">Welcome {{ Auth::user()->firstname }}
                {{ Auth::user()->lastname }}! 🎉</h5>
            <p class="mb-3">You are connected as
                <strong>{{ Auth::user()->roles->first()->label }}</strong>
            </p>
            <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">
                <i class="icon-base bx bx-user me-1"></i> See Profile
            </a>
        </div>
    </div>
    <div class="col-sm-5 text-center text-sm-left">
        <div class="card-body pb-0 px-0 px-md-6">
            <img src="{{ asset('admin-template/assets/img/illustrations/man-with-laptop.png') }}" height="175"
                alt="Welcome">
        </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalStudents'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Students</p>
                    </div>
                    <i class="icon-base bx bx-user-circle text-primary" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalContracts'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Contracts <span
                                class="badge bg-success ms-2">{{ $dashboardData['activeContracts'] ?? 0 }}</span></p>
                    </div>
                    <i class="icon-base bx bx-receipt text-success" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalPayments'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Payments</p>
                    </div>
                    <i class="icon-base bx bx-money text-info" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalBillingPeriods'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Periods</p>
                    </div>
                    <i class="icon-base bx bx-calendar text-warning" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xxl-6 col-lg-12 col-md-4 order-1">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body pb-4">
                        <span class="d-block fw-medium mb-1">Order</span>
                        <h4 class="card-title mb-0">276k</h4>
                    </div>
                    <div id="orderChart" class="pb-3 pe-1" style="min-height: 80px;">
                        <div id="apexchartsm45vcs8f" class="apexcharts-canvas apexchartsm45vcs8f apexcharts-theme-"
                            style="width: 206px; height: 80px;"><svg xmlns="http://www.w3.org/2000/svg"
                                version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" class="apexcharts-svg"
                                xmlns:data="ApexChartsNS" transform="translate(0, 0)" width="206" height="80">
                                <foreignObject x="0" y="0" width="206" height="80">
                                    <div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml"
                                        style="max-height: 40px;"></div>
                                    <style type="text/css">
                                        .apexcharts-flip-y {
                                            transform: scaleY(-1) translateY(-100%);
                                            transform-origin: top;
                                            transform-box: fill-box;
                                        }

                                        .apexcharts-flip-x {
                                            transform: scaleX(-1);
                                            transform-origin: center;
                                            transform-box: fill-box;
                                        }

                                        .apexcharts-legend {
                                            display: flex;
                                            overflow: auto;
                                            padding: 0 10px;
                                        }

                                        .apexcharts-legend.apexcharts-legend-group-horizontal {
                                            flex-direction: column;
                                        }

                                        .apexcharts-legend-group {
                                            display: flex;
                                        }

                                        .apexcharts-legend-group-vertical {
                                            flex-direction: column-reverse;
                                        }

                                        .apexcharts-legend.apx-legend-position-bottom,
                                        .apexcharts-legend.apx-legend-position-top {
                                            flex-wrap: wrap
                                        }

                                        .apexcharts-legend.apx-legend-position-right,
                                        .apexcharts-legend.apx-legend-position-left {
                                            flex-direction: column;
                                            bottom: 0;
                                        }

                                        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left,
                                        .apexcharts-legend.apx-legend-position-top.apexcharts-align-left,
                                        .apexcharts-legend.apx-legend-position-right,
                                        .apexcharts-legend.apx-legend-position-left {
                                            justify-content: flex-start;
                                            align-items: flex-start;
                                        }

                                        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center,
                                        .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {
                                            justify-content: center;
                                            align-items: center;
                                        }

                                        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right,
                                        .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
                                            justify-content: flex-end;
                                            align-items: flex-end;
                                        }

                                        .apexcharts-legend-series {
                                            cursor: pointer;
                                            line-height: normal;
                                            display: flex;
                                            align-items: center;
                                        }

                                        .apexcharts-legend-text {
                                            position: relative;
                                            font-size: 14px;
                                        }

                                        .apexcharts-legend-text *,
                                        .apexcharts-legend-marker * {
                                            pointer-events: none;
                                        }

                                        .apexcharts-legend-marker {
                                            position: relative;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            cursor: pointer;
                                            margin-right: 1px;
                                        }

                                        .apexcharts-legend-series.apexcharts-no-click {
                                            cursor: auto;
                                        }

                                        .apexcharts-legend .apexcharts-hidden-zero-series,
                                        .apexcharts-legend .apexcharts-hidden-null-series {
                                            display: none !important;
                                        }

                                        .apexcharts-inactive-legend {
                                            opacity: 0.45;
                                        }
                                    </style>
                                </foreignObject>
                                <rect width="0" height="0" x="0" y="0" rx="0" ry="0"
                                    opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                    fill="#fefefe">
                                </rect>
                                <g class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)"></g>
                                <g class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)"></g>
                                <g class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
                                <g class="apexcharts-inner apexcharts-graphical"
                                    transform="translate(4.666666666666667, 15)">
                                    <defs>
                                        <clipPath id="gridRectMaskm45vcs8f">
                                            <rect width="194.33333333333334" height="60.333333333333336" x="0" y="0"
                                                rx="0" ry="0" opacity="1" stroke-width="0"
                                                stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                        </clipPath>
                                        <clipPath id="gridRectBarMaskm45vcs8f">
                                            <rect width="200.33333333333334" height="66.33333333333334" x="-3" y="-3"
                                                rx="0" ry="0" opacity="1" stroke-width="0"
                                                stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                        </clipPath>
                                        <clipPath id="gridRectMarkerMaskm45vcs8f">
                                            <rect width="208.33333333333334" height="74.33333333333334" x="-7" y="-7"
                                                rx="0" ry="0" opacity="1" stroke-width="0"
                                                stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                        </clipPath>
                                        <clipPath id="forecastMaskm45vcs8f"></clipPath>
                                        <clipPath id="nonForecastMaskm45vcs8f"></clipPath>
                                        <linearGradient x1="0" y1="0" x2="0" y2="1"
                                            id="SvgjsLinearGradient1363">
                                            <stop stop-opacity="0.4" stop-color="var(--bs-success)" offset="0">
                                            </stop>
                                            <stop stop-opacity="0.4" stop-color="var(--bs-paper-bg)" offset="1">
                                            </stop>
                                            <stop stop-opacity="0.4" stop-color="var(--bs-paper-bg)" offset="1">
                                            </stop>
                                        </linearGradient>
                                    </defs>
                                    <line x1="0" y1="0" x2="0" y2="60.333333333333336"
                                        stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt"
                                        class="apexcharts-xcrosshairs" x="0" y="0" width="1"
                                        height="60.333333333333336" fill="#b1b9c4" filter="none" fill-opacity="0.9"
                                        stroke-width="1"></line>
                                    <g class="apexcharts-grid">
                                        <g class="apexcharts-gridlines-horizontal" style="display: none;">
                                            <line x1="0" y1="0" x2="194.33333333333334"
                                                y2="0" stroke="#e0e0e0" stroke-dasharray="0"
                                                stroke-linecap="butt" class="apexcharts-gridline"></line>
                                            <line x1="0" y1="30.166666666666668" x2="194.33333333333334"
                                                y2="30.166666666666668" stroke="#e0e0e0" stroke-dasharray="0"
                                                stroke-linecap="butt" class="apexcharts-gridline"></line>
                                            <line x1="0" y1="60.333333333333336" x2="194.33333333333334"
                                                y2="60.333333333333336" stroke="#e0e0e0" stroke-dasharray="0"
                                                stroke-linecap="butt" class="apexcharts-gridline"></line>
                                        </g>
                                        <g class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                        <line x1="0" y1="60.333333333333336" x2="194.33333333333334"
                                            y2="60.333333333333336" stroke="transparent" stroke-dasharray="0"
                                            stroke-linecap="butt"></line>
                                        <line x1="0" y1="1" x2="0" y2="60.333333333333336"
                                            stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
                                    </g>
                                    <g class="apexcharts-grid-borders" style="display: none;"></g>
                                    <g class="apexcharts-area-series apexcharts-plot-series">
                                        <g class="apexcharts-series" zIndex="0" seriesName="series-1"
                                            data:longestSeries="true" rel="1" data:realIndex="0">
                                            <path
                                                d="M 0 36.2C 11.336111111111112 36.2 21.05277777777778 37.708333333333336 32.38888888888889 37.708333333333336C 43.72500000000001 37.708333333333336 53.44166666666668 7.541666666666671 64.77777777777779 7.541666666666671C 76.1138888888889 7.541666666666671 85.83055555555556 48.266666666666666 97.16666666666667 48.266666666666666C 108.50277777777778 48.266666666666666 118.21944444444446 28.65833333333333 129.55555555555557 28.65833333333333C 140.89166666666668 28.65833333333333 150.60833333333335 33.18333333333333 161.94444444444446 33.18333333333333C 173.28055555555557 33.18333333333333 182.99722222222223 1.5083333333333258 194.33333333333334 1.5083333333333258C 194.33333333333334 1.5083333333333258 194.33333333333334 1.5083333333333258 194.33333333333334 60.333333333333336 L 0 60.333333333333336z"
                                                fill="url(#SvgjsLinearGradient1363)" fill-opacity="1" stroke="none"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="0"
                                                stroke-dasharray="0" class="apexcharts-area" index="0"
                                                clip-path="url(#gridRectMaskm45vcs8f)"
                                                pathTo="M 0 36.2C 11.336111111111112 36.2 21.05277777777778 37.708333333333336 32.38888888888889 37.708333333333336C 43.72500000000001 37.708333333333336 53.44166666666668 7.541666666666671 64.77777777777779 7.541666666666671C 76.1138888888889 7.541666666666671 85.83055555555556 48.266666666666666 97.16666666666667 48.266666666666666C 108.50277777777778 48.266666666666666 118.21944444444446 28.65833333333333 129.55555555555557 28.65833333333333C 140.89166666666668 28.65833333333333 150.60833333333335 33.18333333333333 161.94444444444446 33.18333333333333C 173.28055555555557 33.18333333333333 182.99722222222223 1.5083333333333258 194.33333333333334 1.5083333333333258C 194.33333333333334 1.5083333333333258 194.33333333333334 1.5083333333333258 194.33333333333334 60.333333333333336 L 0 60.333333333333336z"
                                                pathFrom="M 0 60.333333333333336 L 0 60.333333333333336 L 32.38888888888889 60.333333333333336 L 64.77777777777779 60.333333333333336 L 97.16666666666667 60.333333333333336 L 129.55555555555557 60.333333333333336 L 161.94444444444446 60.333333333333336 L 194.33333333333334 60.333333333333336z">
                                            </path>
                                            <path
                                                d="M 0 36.2C 11.336111111111112 36.2 21.05277777777778 37.708333333333336 32.38888888888889 37.708333333333336C 43.72500000000001 37.708333333333336 53.44166666666668 7.541666666666671 64.77777777777779 7.541666666666671C 76.1138888888889 7.541666666666671 85.83055555555556 48.266666666666666 97.16666666666667 48.266666666666666C 108.50277777777778 48.266666666666666 118.21944444444446 28.65833333333333 129.55555555555557 28.65833333333333C 140.89166666666668 28.65833333333333 150.60833333333335 33.18333333333333 161.94444444444446 33.18333333333333C 173.28055555555557 33.18333333333333 182.99722222222223 1.5083333333333258 194.33333333333334 1.5083333333333258"
                                                fill="none" fill-opacity="1" stroke="var(--bs-success)"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="2"
                                                stroke-dasharray="0" class="apexcharts-area" index="0"
                                                clip-path="url(#gridRectMaskm45vcs8f)"
                                                pathTo="M 0 36.2C 11.336111111111112 36.2 21.05277777777778 37.708333333333336 32.38888888888889 37.708333333333336C 43.72500000000001 37.708333333333336 53.44166666666668 7.541666666666671 64.77777777777779 7.541666666666671C 76.1138888888889 7.541666666666671 85.83055555555556 48.266666666666666 97.16666666666667 48.266666666666666C 108.50277777777778 48.266666666666666 118.21944444444446 28.65833333333333 129.55555555555557 28.65833333333333C 140.89166666666668 28.65833333333333 150.60833333333335 33.18333333333333 161.94444444444446 33.18333333333333C 173.28055555555557 33.18333333333333 182.99722222222223 1.5083333333333258 194.33333333333334 1.5083333333333258"
                                                pathFrom="M 0 60.333333333333336 L 0 60.333333333333336 L 32.38888888888889 60.333333333333336 L 64.77777777777779 60.333333333333336 L 97.16666666666667 60.333333333333336 L 129.55555555555557 60.333333333333336 L 161.94444444444446 60.333333333333336 L 194.33333333333334 60.333333333333336"
                                                fill-rule="evenodd"></path>
                                            <g class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown"
                                                data:realIndex="0">
                                                <g class="" clip-path="url(#gridRectMarkerMaskm45vcs8f)">
                                                    <path d="M -1, 36.2
           m -6, 0
           a 6,6 0 1,0 12,0
           a 6,6 0 1,0 -12,0" fill="transparent" fill-opacity="1" stroke="transparent" stroke-opacity="0.9"
                                                        stroke-linecap="butt" stroke-width="4" stroke-dasharray="0"
                                                        cx="-1" cy="36.2" shape="circle"
                                                        class="apexcharts-marker no-pointer-events we5mhplyj"
                                                        rel="0" j="0" index="0" default-marker-size="6">
                                                    </path>
                                                    <path d="M 31.388888888888893, 37.708333333333336
           m -6, 0
           a 6,6 0 1,0 12,0
           a 6,6 0 1,0 -12,0" fill="transparent" fill-opacity="1" stroke="transparent" stroke-opacity="0.9"
                                                        stroke-linecap="butt" stroke-width="4" stroke-dasharray="0"
                                                        cx="31.388888888888893" cy="37.708333333333336"
                                                        shape="circle"
                                                        class="apexcharts-marker no-pointer-events wusmgpdd2"
                                                        rel="1" j="1" index="0" default-marker-size="6">
                                                    </path>
                                                </g>
                                                <g class="" clip-path="url(#gridRectMarkerMaskm45vcs8f)">
                                                    <path d="M 63.777777777777786, 7.541666666666671
           m -6, 0
           a 6,6 0 1,0 12,0
           a 6,6 0 1,0 -12,0" fill="transparent" fill-opacity="1" stroke="transparent" stroke-opacity="0.9"
                                                        stroke-linecap="butt" stroke-width="4" stroke-dasharray="0"
                                                        cx="63.777777777777786" cy="7.541666666666671" shape="circle"
                                                        class="apexcharts-marker no-pointer-events wgvqcepci"
                                                        rel="2" j="2" index="0" default-marker-size="6">
                                                    </path>
                                                </g>
                                                <g class="" clip-path="url(#gridRectMarkerMaskm45vcs8f)">
                                                    <path d="M 96.16666666666667, 48.266666666666666
           m -6, 0
           a 6,6 0 1,0 12,0
           a 6,6 0 1,0 -12,0" fill="transparent" fill-opacity="1" stroke="transparent" stroke-opacity="0.9"
                                                        stroke-linecap="butt" stroke-width="4" stroke-dasharray="0"
                                                        cx="96.16666666666667" cy="48.266666666666666" shape="circle"
                                                        class="apexcharts-marker no-pointer-events wo0kk7e7s"
                                                        rel="3" j="3" index="0" default-marker-size="6">
                                                    </path>
                                                </g>
                                                <g class="" clip-path="url(#gridRectMarkerMaskm45vcs8f)">
                                                    <path d="M 128.55555555555557, 28.65833333333333
           m -6, 0
           a 6,6 0 1,0 12,0
           a 6,6 0 1,0 -12,0" fill="transparent" fill-opacity="1" stroke="transparent" stroke-opacity="0.9"
                                                        stroke-linecap="butt" stroke-width="4" stroke-dasharray="0"
                                                        cx="128.55555555555557" cy="28.65833333333333" shape="circle"
                                                        class="apexcharts-marker no-pointer-events wfh54598nh"
                                                        rel="4" j="4" index="0" default-marker-size="6">
                                                    </path>
                                                </g>
                                                <g class="" clip-path="url(#gridRectMarkerMaskm45vcs8f)">
                                                    <path d="M 160.94444444444446, 33.18333333333333
           m -6, 0
           a 6,6 0 1,0 12,0
           a 6,6 0 1,0 -12,0" fill="transparent" fill-opacity="1" stroke="transparent" stroke-opacity="0.9"
                                                        stroke-linecap="butt" stroke-width="4" stroke-dasharray="0"
                                                        cx="160.94444444444446" cy="33.18333333333333" shape="circle"
                                                        class="apexcharts-marker no-pointer-events wth6gxcrt"
                                                        rel="5" j="5" index="0" default-marker-size="6">
                                                    </path>
                                                </g>
                                                <g class="" clip-path="url(#gridRectMarkerMaskm45vcs8f)">
                                                    <path d="M 193.33333333333334, 1.5083333333333258
           m -6, 0
           a 6,6 0 1,0 12,0
           a 6,6 0 1,0 -12,0" fill="var(--bs-paper-bg)" fill-opacity="1" stroke="var(--bs-success)"
                                                        stroke-opacity="0.9" stroke-linecap="butt" stroke-width="4"
                                                        stroke-dasharray="0" cx="193.33333333333334"
                                                        cy="1.5083333333333258" shape="circle"
                                                        class="apexcharts-marker no-pointer-events wjm5tyo31"
                                                        rel="6" j="6" index="0" default-marker-size="6">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                        <g class="apexcharts-datalabels" data:realIndex="0"></g>
                                    </g>
                                    <line x1="0" y1="0" x2="194.33333333333334" y2="0"
                                        stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt"
                                        class="apexcharts-ycrosshairs"></line>
                                    <line x1="0" y1="0" x2="194.33333333333334" y2="0"
                                        stroke="#b6b6b6" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt"
                                        class="apexcharts-ycrosshairs-hidden"></line>
                                    <g class="apexcharts-xaxis" transform="translate(0, 0)">
                                        <g class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
                                    </g>
                                    <g class="apexcharts-yaxis-annotations"></g>
                                    <g class="apexcharts-xaxis-annotations"></g>
                                    <g class="apexcharts-point-annotations"></g>
                                </g>
                            </svg>
                            <div class="apexcharts-tooltip apexcharts-theme-light">
                                <div class="apexcharts-tooltip-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                <div class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-0"
                                    style="order: 1;"><span class="apexcharts-tooltip-marker"
                                        style="background-color: var(--bs-success);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-y-label"></span><span
                                                class="apexcharts-tooltip-text-y-value"></span></div>
                                        <div class="apexcharts-tooltip-goals-group"><span
                                                class="apexcharts-tooltip-text-goals-label"></span><span
                                                class="apexcharts-tooltip-text-goals-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                <div class="apexcharts-yaxistooltip-text"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('admin-template/assets') }}/img/icons/unicons/wallet-info.png"
                                    alt="wallet info" class="rounded">
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <p class="mb-1">Sales</p>
                        <h4 class="card-title mb-3">$4,679</h4>
                        <small class="text-success fw-medium"><i class="icon-base bx bx-up-arrow-alt"></i>
                            +28.42%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-8 col-lg-12 col-xxl-6 order-3 order-md-2">
        <div class="row">
            <div class="col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('admin-template/assets') }}/img/icons/unicons/paypal.png"
                                    alt="paypal" class="rounded">
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <p class="mb-1">Payments</p>
                        <h4 class="card-title mb-3">$2,456</h4>
                        <small class="text-danger fw-medium"><i class="icon-base bx bx-down-arrow-alt"></i>
                            -14.82%</small>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body pb-0">
                        <span class="d-block fw-medium mb-1">Revenue</span>
                        <h4 class="card-title mb-0 mb-lg-4">425k</h4>
                        <div id="revenueChart" style="min-height: 110px;" class="">
                            <div id="apexchartsf0llc0yxi"
                                class="apexcharts-canvas apexchartsf0llc0yxi apexcharts-theme-"
                                style="width: 162px; height: 95px;"><svg xmlns="http://www.w3.org/2000/svg"
                                    version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" class="apexcharts-svg"
                                    xmlns:data="ApexChartsNS" transform="translate(0, 0)" width="162"
                                    height="95">
                                    <foreignObject x="0" y="0" width="162" height="95">
                                        <div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml"
                                            style="max-height: 47.5px;"></div>
                                        <style type="text/css">
                                            .apexcharts-flip-y {
                                                transform: scaleY(-1) translateY(-100%);
                                                transform-origin: top;
                                                transform-box: fill-box;
                                            }

                                            .apexcharts-flip-x {
                                                transform: scaleX(-1);
                                                transform-origin: center;
                                                transform-box: fill-box;
                                            }

                                            .apexcharts-legend {
                                                display: flex;
                                                overflow: auto;
                                                padding: 0 10px;
                                            }

                                            .apexcharts-legend.apexcharts-legend-group-horizontal {
                                                flex-direction: column;
                                            }

                                            .apexcharts-legend-group {
                                                display: flex;
                                            }

                                            .apexcharts-legend-group-vertical {
                                                flex-direction: column-reverse;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom,
                                            .apexcharts-legend.apx-legend-position-top {
                                                flex-wrap: wrap
                                            }

                                            .apexcharts-legend.apx-legend-position-right,
                                            .apexcharts-legend.apx-legend-position-left {
                                                flex-direction: column;
                                                bottom: 0;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-left,
                                            .apexcharts-legend.apx-legend-position-right,
                                            .apexcharts-legend.apx-legend-position-left {
                                                justify-content: flex-start;
                                                align-items: flex-start;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {
                                                justify-content: center;
                                                align-items: center;
                                            }

                                            .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right,
                                            .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
                                                justify-content: flex-end;
                                                align-items: flex-end;
                                            }

                                            .apexcharts-legend-series {
                                                cursor: pointer;
                                                line-height: normal;
                                                display: flex;
                                                align-items: center;
                                            }

                                            .apexcharts-legend-text {
                                                position: relative;
                                                font-size: 14px;
                                            }

                                            .apexcharts-legend-text *,
                                            .apexcharts-legend-marker * {
                                                pointer-events: none;
                                            }

                                            .apexcharts-legend-marker {
                                                position: relative;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                cursor: pointer;
                                                margin-right: 1px;
                                            }

                                            .apexcharts-legend-series.apexcharts-no-click {
                                                cursor: auto;
                                            }

                                            .apexcharts-legend .apexcharts-hidden-zero-series,
                                            .apexcharts-legend .apexcharts-hidden-null-series {
                                                display: none !important;
                                            }

                                            .apexcharts-inactive-legend {
                                                opacity: 0.45;
                                            }
                                        </style>
                                    </foreignObject>
                                    <g class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)"></g>
                                    <g class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)"></g>
                                    <g class="apexcharts-yaxis" rel="0" transform="translate(-8, 0)">
                                        <g class="apexcharts-yaxis-texts-g"></g>
                                    </g>
                                    <g class="apexcharts-inner apexcharts-graphical" transform="translate(0, 10)">
                                        <defs>
                                            <linearGradient x1="0" y1="0" x2="0"
                                                y2="1" id="SvgjsLinearGradient1362">
                                                <stop stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)"
                                                    offset="0"></stop>
                                                <stop stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)"
                                                    offset="1"></stop>
                                                <stop stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)"
                                                    offset="1"></stop>
                                            </linearGradient>
                                            <clipPath id="gridRectMaskf0llc0yxi">
                                                <rect width="154.3333330154419" height="60.42666563796997" x="0" y="0"
                                                    rx="0" ry="0" opacity="1" stroke-width="0"
                                                    stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="gridRectBarMaskf0llc0yxi">
                                                <rect width="158.3333330154419" height="64.42666563796996" x="-2"
                                                    y="-2" rx="0" ry="0" opacity="1"
                                                    stroke-width="0" stroke="none" stroke-dasharray="0"
                                                    fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="gridRectMarkerMaskf0llc0yxi">
                                                <rect width="154.3333330154419" height="60.42666563796997" x="0" y="0"
                                                    rx="0" ry="0" opacity="1" stroke-width="0"
                                                    stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="forecastMaskf0llc0yxi"></clipPath>
                                            <clipPath id="nonForecastMaskf0llc0yxi"></clipPath>
                                        </defs>
                                        <rect width="16.535714251654486" height="60.42666563796997" x="0" y="0"
                                            rx="0" ry="0" opacity="1" stroke-width="0"
                                            stroke="#b6b6b6" stroke-dasharray="3"
                                            fill="url(#SvgjsLinearGradient1362)" class="apexcharts-xcrosshairs"
                                            y2="60.42666563796997" filter="none" fill-opacity="0.9"></rect>
                                        <g class="apexcharts-grid">
                                            <g class="apexcharts-gridlines-horizontal" style="display: none;">
                                                <line x1="0" y1="0" x2="154.3333330154419"
                                                    y2="0" stroke="#e0e0e0" stroke-dasharray="0"
                                                    stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                <line x1="0" y1="30.213332818984984" x2="154.3333330154419"
                                                    y2="30.213332818984984" stroke="#e0e0e0" stroke-dasharray="0"
                                                    stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                <line x1="0" y1="60.42666563796997" x2="154.3333330154419"
                                                    y2="60.42666563796997" stroke="#e0e0e0" stroke-dasharray="0"
                                                    stroke-linecap="butt" class="apexcharts-gridline"></line>
                                            </g>
                                            <g class="apexcharts-gridlines-vertical" style="display: none;"></g>
                                            <line x1="0" y1="60.42666563796997" x2="154.3333330154419"
                                                y2="60.42666563796997" stroke="transparent" stroke-dasharray="0"
                                                stroke-linecap="butt"></line>
                                            <line x1="0" y1="1" x2="0"
                                                y2="60.42666563796997" stroke="transparent" stroke-dasharray="0"
                                                stroke-linecap="butt"></line>
                                        </g>
                                        <g class="apexcharts-grid-borders" style="display: none;"></g>
                                        <g class="apexcharts-bar-series apexcharts-plot-series">
                                            <g class="apexcharts-series" rel="1" seriesName="series-1"
                                                data:realIndex="0">
                                                <path
                                                    d="M 2.755952375275749 56.427665637969966 L 2.755952375275749 40.25699938278198 C 2.755952375275749 38.25699938278198 4.755952375275749 36.25699938278198 6.755952375275749 36.25699938278198 L 15.291666626930237 36.25699938278198 C 17.291666626930237 36.25699938278198 19.291666626930237 38.25699938278198 19.291666626930237 40.25699938278198 L 19.291666626930237 56.427665637969966 C 19.291666626930237 58.427665637969966 17.291666626930237 60.427665637969966 15.291666626930237 60.427665637969966 L 6.755952375275749 60.427665637969966 C 4.755952375275749 60.427665637969966 2.755952375275749 58.427665637969966 2.755952375275749 56.427665637969966 Z "
                                                    fill="var(--bs-primary-bg-subtle)" fill-opacity="1"
                                                    stroke="var(--bs-primary-bg-subtle)" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area undefined" index="0"
                                                    clip-path="url(#gridRectBarMaskf0llc0yxi)"
                                                    pathTo="M 2.755952375275749 56.427665637969966 L 2.755952375275749 40.25699938278198 C 2.755952375275749 38.25699938278198 4.755952375275749 36.25699938278198 6.755952375275749 36.25699938278198 L 15.291666626930237 36.25699938278198 C 17.291666626930237 36.25699938278198 19.291666626930237 38.25699938278198 19.291666626930237 40.25699938278198 L 19.291666626930237 56.427665637969966 C 19.291666626930237 58.427665637969966 17.291666626930237 60.427665637969966 15.291666626930237 60.427665637969966 L 6.755952375275749 60.427665637969966 C 4.755952375275749 60.427665637969966 2.755952375275749 58.427665637969966 2.755952375275749 56.427665637969966 Z "
                                                    pathFrom="M 2.755952375275749 60.427665637969966 L 2.755952375275749 60.427665637969966 L 19.291666626930237 60.427665637969966 L 19.291666626930237 60.427665637969966 L 19.291666626930237 60.427665637969966 L 19.291666626930237 60.427665637969966 L 19.291666626930237 60.427665637969966 L 2.755952375275749 60.427665637969966 Z"
                                                    cy="36.25599938278198" cx="24.80357137748173" j="0"
                                                    val="40" barHeight="24.170666255187985"
                                                    barWidth="16.535714251654486"></path>
                                                <path
                                                    d="M 24.80357137748173 56.427665637969966 L 24.80357137748173 7.022333281898499 C 24.80357137748173 5.022333281898499 26.80357137748173 3.0223332818984994 28.80357137748173 3.0223332818984994 L 37.339285629136214 3.0223332818984994 C 39.339285629136214 3.0223332818984994 41.339285629136214 5.022333281898499 41.339285629136214 7.022333281898499 L 41.339285629136214 56.427665637969966 C 41.339285629136214 58.427665637969966 39.339285629136214 60.427665637969966 37.339285629136214 60.427665637969966 L 28.80357137748173 60.427665637969966 C 26.80357137748173 60.427665637969966 24.80357137748173 58.427665637969966 24.80357137748173 56.427665637969966 Z "
                                                    fill="var(--bs-primary-bg-subtle)" fill-opacity="1"
                                                    stroke="var(--bs-primary-bg-subtle)" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area undefined" index="0"
                                                    clip-path="url(#gridRectBarMaskf0llc0yxi)"
                                                    pathTo="M 24.80357137748173 56.427665637969966 L 24.80357137748173 7.022333281898499 C 24.80357137748173 5.022333281898499 26.80357137748173 3.0223332818984994 28.80357137748173 3.0223332818984994 L 37.339285629136214 3.0223332818984994 C 39.339285629136214 3.0223332818984994 41.339285629136214 5.022333281898499 41.339285629136214 7.022333281898499 L 41.339285629136214 56.427665637969966 C 41.339285629136214 58.427665637969966 39.339285629136214 60.427665637969966 37.339285629136214 60.427665637969966 L 28.80357137748173 60.427665637969966 C 26.80357137748173 60.427665637969966 24.80357137748173 58.427665637969966 24.80357137748173 56.427665637969966 Z "
                                                    pathFrom="M 24.80357137748173 60.427665637969966 L 24.80357137748173 60.427665637969966 L 41.339285629136214 60.427665637969966 L 41.339285629136214 60.427665637969966 L 41.339285629136214 60.427665637969966 L 41.339285629136214 60.427665637969966 L 41.339285629136214 60.427665637969966 L 24.80357137748173 60.427665637969966 Z"
                                                    cy="3.0213332818984995" cx="46.851190379687715" j="1"
                                                    val="95" barHeight="57.40533235607147"
                                                    barWidth="16.535714251654486"></path>
                                                <path
                                                    d="M 46.851190379687715 56.427665637969966 L 46.851190379687715 28.17166625518799 C 46.851190379687715 26.17166625518799 48.851190379687715 24.17166625518799 50.851190379687715 24.17166625518799 L 59.386904631342205 24.17166625518799 C 61.386904631342205 24.17166625518799 63.386904631342205 26.17166625518799 63.386904631342205 28.17166625518799 L 63.386904631342205 56.427665637969966 C 63.386904631342205 58.427665637969966 61.386904631342205 60.427665637969966 59.386904631342205 60.427665637969966 L 50.851190379687715 60.427665637969966 C 48.851190379687715 60.427665637969966 46.851190379687715 58.427665637969966 46.851190379687715 56.427665637969966 Z "
                                                    fill="var(--bs-primary-bg-subtle)" fill-opacity="1"
                                                    stroke="var(--bs-primary-bg-subtle)" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area undefined" index="0"
                                                    clip-path="url(#gridRectBarMaskf0llc0yxi)"
                                                    pathTo="M 46.851190379687715 56.427665637969966 L 46.851190379687715 28.17166625518799 C 46.851190379687715 26.17166625518799 48.851190379687715 24.17166625518799 50.851190379687715 24.17166625518799 L 59.386904631342205 24.17166625518799 C 61.386904631342205 24.17166625518799 63.386904631342205 26.17166625518799 63.386904631342205 28.17166625518799 L 63.386904631342205 56.427665637969966 C 63.386904631342205 58.427665637969966 61.386904631342205 60.427665637969966 59.386904631342205 60.427665637969966 L 50.851190379687715 60.427665637969966 C 48.851190379687715 60.427665637969966 46.851190379687715 58.427665637969966 46.851190379687715 56.427665637969966 Z "
                                                    pathFrom="M 46.851190379687715 60.427665637969966 L 46.851190379687715 60.427665637969966 L 63.386904631342205 60.427665637969966 L 63.386904631342205 60.427665637969966 L 63.386904631342205 60.427665637969966 L 63.386904631342205 60.427665637969966 L 63.386904631342205 60.427665637969966 L 46.851190379687715 60.427665637969966 Z"
                                                    cy="24.17066625518799" cx="68.8988093818937" j="2" val="60"
                                                    barHeight="36.25599938278198" barWidth="16.535714251654486">
                                                </path>
                                                <path
                                                    d="M 68.8988093818937 56.427665637969966 L 68.8988093818937 37.235666100883485 C 68.8988093818937 35.235666100883485 70.8988093818937 33.235666100883485 72.8988093818937 33.235666100883485 L 81.43452363354818 33.235666100883485 C 83.43452363354818 33.235666100883485 85.43452363354818 35.235666100883485 85.43452363354818 37.235666100883485 L 85.43452363354818 56.427665637969966 C 85.43452363354818 58.427665637969966 83.43452363354818 60.427665637969966 81.43452363354818 60.427665637969966 L 72.8988093818937 60.427665637969966 C 70.8988093818937 60.427665637969966 68.8988093818937 58.427665637969966 68.8988093818937 56.427665637969966 Z "
                                                    fill="var(--bs-primary-bg-subtle)" fill-opacity="1"
                                                    stroke="var(--bs-primary-bg-subtle)" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area undefined" index="0"
                                                    clip-path="url(#gridRectBarMaskf0llc0yxi)"
                                                    pathTo="M 68.8988093818937 56.427665637969966 L 68.8988093818937 37.235666100883485 C 68.8988093818937 35.235666100883485 70.8988093818937 33.235666100883485 72.8988093818937 33.235666100883485 L 81.43452363354818 33.235666100883485 C 83.43452363354818 33.235666100883485 85.43452363354818 35.235666100883485 85.43452363354818 37.235666100883485 L 85.43452363354818 56.427665637969966 C 85.43452363354818 58.427665637969966 83.43452363354818 60.427665637969966 81.43452363354818 60.427665637969966 L 72.8988093818937 60.427665637969966 C 70.8988093818937 60.427665637969966 68.8988093818937 58.427665637969966 68.8988093818937 56.427665637969966 Z "
                                                    pathFrom="M 68.8988093818937 60.427665637969966 L 68.8988093818937 60.427665637969966 L 85.43452363354818 60.427665637969966 L 85.43452363354818 60.427665637969966 L 85.43452363354818 60.427665637969966 L 85.43452363354818 60.427665637969966 L 85.43452363354818 60.427665637969966 L 68.8988093818937 60.427665637969966 Z"
                                                    cy="33.23466610088349" cx="90.94642838409968" j="3"
                                                    val="45" barHeight="27.191999537086485"
                                                    barWidth="16.535714251654486"></path>
                                                <path
                                                    d="M 90.94642838409968 56.427665637969966 L 90.94642838409968 10.043666563797 C 90.94642838409968 8.043666563797 92.94642838409968 6.043666563796999 94.94642838409968 6.043666563796999 L 103.48214263575416 6.043666563796999 C 105.48214263575416 6.043666563796999 107.48214263575416 8.043666563797 107.48214263575416 10.043666563797 L 107.48214263575416 56.427665637969966 C 107.48214263575416 58.427665637969966 105.48214263575416 60.427665637969966 103.48214263575416 60.427665637969966 L 94.94642838409968 60.427665637969966 C 92.94642838409968 60.427665637969966 90.94642838409968 58.427665637969966 90.94642838409968 56.427665637969966 Z "
                                                    fill="var(--bs-primary)" fill-opacity="1"
                                                    stroke="var(--bs-primary)" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area undefined" index="0"
                                                    clip-path="url(#gridRectBarMaskf0llc0yxi)"
                                                    pathTo="M 90.94642838409968 56.427665637969966 L 90.94642838409968 10.043666563797 C 90.94642838409968 8.043666563797 92.94642838409968 6.043666563796999 94.94642838409968 6.043666563796999 L 103.48214263575416 6.043666563796999 C 105.48214263575416 6.043666563796999 107.48214263575416 8.043666563797 107.48214263575416 10.043666563797 L 107.48214263575416 56.427665637969966 C 107.48214263575416 58.427665637969966 105.48214263575416 60.427665637969966 103.48214263575416 60.427665637969966 L 94.94642838409968 60.427665637969966 C 92.94642838409968 60.427665637969966 90.94642838409968 58.427665637969966 90.94642838409968 56.427665637969966 Z "
                                                    pathFrom="M 90.94642838409968 60.427665637969966 L 90.94642838409968 60.427665637969966 L 107.48214263575416 60.427665637969966 L 107.48214263575416 60.427665637969966 L 107.48214263575416 60.427665637969966 L 107.48214263575416 60.427665637969966 L 107.48214263575416 60.427665637969966 L 90.94642838409968 60.427665637969966 Z"
                                                    cy="6.042666563796999" cx="112.99404738630565" j="4"
                                                    val="90" barHeight="54.38399907417297"
                                                    barWidth="16.535714251654486"></path>
                                                <path
                                                    d="M 112.99404738630565 56.427665637969966 L 112.99404738630565 34.214332818984985 C 112.99404738630565 32.214332818984985 114.99404738630565 30.214332818984985 116.99404738630565 30.214332818984985 L 125.52976163796015 30.214332818984985 C 127.52976163796015 30.214332818984985 129.52976163796015 32.214332818984985 129.52976163796015 34.214332818984985 L 129.52976163796015 56.427665637969966 C 129.52976163796015 58.427665637969966 127.52976163796015 60.427665637969966 125.52976163796015 60.427665637969966 L 116.99404738630565 60.427665637969966 C 114.99404738630565 60.427665637969966 112.99404738630565 58.427665637969966 112.99404738630565 56.427665637969966 Z "
                                                    fill="var(--bs-primary-bg-subtle)" fill-opacity="1"
                                                    stroke="var(--bs-primary-bg-subtle)" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area undefined" index="0"
                                                    clip-path="url(#gridRectBarMaskf0llc0yxi)"
                                                    pathTo="M 112.99404738630565 56.427665637969966 L 112.99404738630565 34.214332818984985 C 112.99404738630565 32.214332818984985 114.99404738630565 30.214332818984985 116.99404738630565 30.214332818984985 L 125.52976163796015 30.214332818984985 C 127.52976163796015 30.214332818984985 129.52976163796015 32.214332818984985 129.52976163796015 34.214332818984985 L 129.52976163796015 56.427665637969966 C 129.52976163796015 58.427665637969966 127.52976163796015 60.427665637969966 125.52976163796015 60.427665637969966 L 116.99404738630565 60.427665637969966 C 114.99404738630565 60.427665637969966 112.99404738630565 58.427665637969966 112.99404738630565 56.427665637969966 Z "
                                                    pathFrom="M 112.99404738630565 60.427665637969966 L 112.99404738630565 60.427665637969966 L 129.52976163796015 60.427665637969966 L 129.52976163796015 60.427665637969966 L 129.52976163796015 60.427665637969966 L 129.52976163796015 60.427665637969966 L 129.52976163796015 60.427665637969966 L 112.99404738630565 60.427665637969966 Z"
                                                    cy="30.213332818984984" cx="135.04166638851163" j="5"
                                                    val="50" barHeight="30.213332818984984"
                                                    barWidth="16.535714251654486"></path>
                                                <path
                                                    d="M 135.04166638851163 56.427665637969966 L 135.04166638851163 19.107666409492488 C 135.04166638851163 17.107666409492488 137.04166638851163 15.10766640949249 139.04166638851163 15.10766640949249 L 147.57738064016613 15.10766640949249 C 149.57738064016613 15.10766640949249 151.57738064016613 17.107666409492488 151.57738064016613 19.107666409492488 L 151.57738064016613 56.427665637969966 C 151.57738064016613 58.427665637969966 149.57738064016613 60.427665637969966 147.57738064016613 60.427665637969966 L 139.04166638851163 60.427665637969966 C 137.04166638851163 60.427665637969966 135.04166638851163 58.427665637969966 135.04166638851163 56.427665637969966 Z "
                                                    fill="var(--bs-primary-bg-subtle)" fill-opacity="1"
                                                    stroke="var(--bs-primary-bg-subtle)" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area undefined" index="0"
                                                    clip-path="url(#gridRectBarMaskf0llc0yxi)"
                                                    pathTo="M 135.04166638851163 56.427665637969966 L 135.04166638851163 19.107666409492488 C 135.04166638851163 17.107666409492488 137.04166638851163 15.10766640949249 139.04166638851163 15.10766640949249 L 147.57738064016613 15.10766640949249 C 149.57738064016613 15.10766640949249 151.57738064016613 17.107666409492488 151.57738064016613 19.107666409492488 L 151.57738064016613 56.427665637969966 C 151.57738064016613 58.427665637969966 149.57738064016613 60.427665637969966 147.57738064016613 60.427665637969966 L 139.04166638851163 60.427665637969966 C 137.04166638851163 60.427665637969966 135.04166638851163 58.427665637969966 135.04166638851163 56.427665637969966 Z "
                                                    pathFrom="M 135.04166638851163 60.427665637969966 L 135.04166638851163 60.427665637969966 L 151.57738064016613 60.427665637969966 L 151.57738064016613 60.427665637969966 L 151.57738064016613 60.427665637969966 L 151.57738064016613 60.427665637969966 L 151.57738064016613 60.427665637969966 L 135.04166638851163 60.427665637969966 Z"
                                                    cy="15.10666640949249" cx="157.0892853907176" j="6"
                                                    val="75" barHeight="45.31999922847748"
                                                    barWidth="16.535714251654486"></path>
                                                <g class="apexcharts-bar-goals-markers">
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskf0llc0yxi)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskf0llc0yxi)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskf0llc0yxi)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskf0llc0yxi)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskf0llc0yxi)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskf0llc0yxi)"></g>
                                                    <g className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMaskf0llc0yxi)"></g>
                                                </g>
                                                <g class="apexcharts-bar-shadows apexcharts-hidden-element-shown"></g>
                                            </g>
                                            <g class="apexcharts-datalabels apexcharts-hidden-element-shown"
                                                data:realIndex="0"></g>
                                        </g>
                                        <line x1="0" y1="0" x2="154.3333330154419" y2="0"
                                            stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                            stroke-linecap="butt" class="apexcharts-ycrosshairs">
                                        </line>
                                        <line x1="0" y1="0" x2="154.3333330154419" y2="0"
                                            stroke="#b6b6b6" stroke-dasharray="0" stroke-width="0"
                                            stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line>
                                        <g class="apexcharts-xaxis" transform="translate(0, 0)">
                                            <g class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text
                                                    x="11.023809501102992" y="88.42666563796996" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="13px"
                                                    font-family="Helvetica, Arial, sans-serif" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan>M</tspan>
                                                    <title>M</title>
                                                </text><text x="33.07142850330898" y="88.42666563796996"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="13px"
                                                    font-family="Helvetica, Arial, sans-serif" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan>T</tspan>
                                                    <title>T</title>
                                                </text><text x="55.11904750551497" y="88.42666563796996"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="13px"
                                                    font-family="Helvetica, Arial, sans-serif" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan>W</tspan>
                                                    <title>W</title>
                                                </text><text x="77.16666650772095" y="88.42666563796996"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="13px"
                                                    font-family="Helvetica, Arial, sans-serif" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan>T</tspan>
                                                    <title>T</title>
                                                </text><text x="99.21428550992692" y="88.42666563796996"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="13px"
                                                    font-family="Helvetica, Arial, sans-serif" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan>F</tspan>
                                                    <title>F</title>
                                                </text><text x="121.2619045121329" y="88.42666563796996"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="13px"
                                                    font-family="Helvetica, Arial, sans-serif" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan>S</tspan>
                                                    <title>S</title>
                                                </text><text x="143.30952351433888" y="88.42666563796996"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="13px"
                                                    font-family="Helvetica, Arial, sans-serif" font-weight="400"
                                                    fill="var(--bs-secondary-color)"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan>S</tspan>
                                                    <title>S</title>
                                                </text></g>
                                        </g>
                                        <g class="apexcharts-yaxis-annotations"></g>
                                        <g class="apexcharts-xaxis-annotations"></g>
                                        <g class="apexcharts-point-annotations"></g>
                                    </g>
                                </svg>
                                <div class="apexcharts-tooltip apexcharts-theme-light">
                                    <div class="apexcharts-tooltip-title"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                    <div class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-0"
                                        style="order: 1;"><span class="apexcharts-tooltip-marker"
                                            style="background-color: var(--bs-primary-bg-subtle);"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                    <div class="apexcharts-yaxistooltip-text"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<div class="row">
    <div class="col-12 mb-6">
        <div class="card">
            <div class="card-body">
                <div
                    class="d-flex justify-content-between align-items-center flex-sm-row flex-column gap-10 flex-wrap">
                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                        <div class="card-title mb-6">
                            <h5 class="text-nowrap mb-1">Profile Report</h5>
                            <span class="badge bg-label-warning">YEAR 2022</span>
                        </div>
                        <div class="mt-sm-auto">
                            <span class="text-success text-nowrap fw-medium"><i
                                    class="icon-base bx bx-up-arrow-alt"></i> 68.2%</span>
                            <h4 class="mb-0">$84,686k</h4>
                        </div>
                    </div>
                    <div id="profileReportChart" style="min-height: 75px;" class="">
                        <div id="apexcharts4w4kvm9i" class="apexcharts-canvas apexcharts4w4kvm9i apexcharts-theme-"
                            style="width: 240px; height: 75px;"><svg xmlns="http://www.w3.org/2000/svg"
                                version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" class="apexcharts-svg"
                                xmlns:data="ApexChartsNS" transform="translate(0, 0)" width="240"
                                height="75">
                                <foreignObject x="0" y="0" width="240" height="75">
                                    <div class="apexcharts-legend" xmlns="http://www.w3.org/1999/xhtml"
                                        style="max-height: 37.5px;"></div>
                                    <style type="text/css">
                                        .apexcharts-flip-y {
                                            transform: scaleY(-1) translateY(-100%);
                                            transform-origin: top;
                                            transform-box: fill-box;
                                        }

                                        .apexcharts-flip-x {
                                            transform: scaleX(-1);
                                            transform-origin: center;
                                            transform-box: fill-box;
                                        }

                                        .apexcharts-legend {
                                            display: flex;
                                            overflow: auto;
                                            padding: 0 10px;
                                        }

                                        .apexcharts-legend.apexcharts-legend-group-horizontal {
                                            flex-direction: column;
                                        }

                                        .apexcharts-legend-group {
                                            display: flex;
                                        }

                                        .apexcharts-legend-group-vertical {
                                            flex-direction: column-reverse;
                                        }

                                        .apexcharts-legend.apx-legend-position-bottom,
                                        .apexcharts-legend.apx-legend-position-top {
                                            flex-wrap: wrap
                                        }

                                        .apexcharts-legend.apx-legend-position-right,
                                        .apexcharts-legend.apx-legend-position-left {
                                            flex-direction: column;
                                            bottom: 0;
                                        }

                                        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left,
                                        .apexcharts-legend.apx-legend-position-top.apexcharts-align-left,
                                        .apexcharts-legend.apx-legend-position-right,
                                        .apexcharts-legend.apx-legend-position-left {
                                            justify-content: flex-start;
                                            align-items: flex-start;
                                        }

                                        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center,
                                        .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {
                                            justify-content: center;
                                            align-items: center;
                                        }

                                        .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right,
                                        .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
                                            justify-content: flex-end;
                                            align-items: flex-end;
                                        }

                                        .apexcharts-legend-series {
                                            cursor: pointer;
                                            line-height: normal;
                                            display: flex;
                                            align-items: center;
                                        }

                                        .apexcharts-legend-text {
                                            position: relative;
                                            font-size: 14px;
                                        }

                                        .apexcharts-legend-text *,
                                        .apexcharts-legend-marker * {
                                            pointer-events: none;
                                        }

                                        .apexcharts-legend-marker {
                                            position: relative;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            cursor: pointer;
                                            margin-right: 1px;
                                        }

                                        .apexcharts-legend-series.apexcharts-no-click {
                                            cursor: auto;
                                        }

                                        .apexcharts-legend .apexcharts-hidden-zero-series,
                                        .apexcharts-legend .apexcharts-hidden-null-series {
                                            display: none !important;
                                        }

                                        .apexcharts-inactive-legend {
                                            opacity: 0.45;
                                        }
                                    </style>
                                </foreignObject>
                                <rect width="0" height="0" x="0" y="0" rx="0" ry="0"
                                    opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                    fill="#fefefe"></rect>
                                <g class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)">
                                </g>
                                <g class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)">
                                </g>
                                <g class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)">
                                </g>
                                <g class="apexcharts-inner apexcharts-graphical" transform="translate(0, 2.5)">
                                    <defs>
                                        <clipPath id="gridRectMask4w4kvm9i">
                                            <rect width="232" height="70" x="0" y="0" rx="0"
                                                ry="0" opacity="1" stroke-width="0" stroke="none"
                                                stroke-dasharray="0" fill="#fff"></rect>
                                        </clipPath>
                                        <clipPath id="gridRectBarMask4w4kvm9i">
                                            <rect width="241" height="79" x="-4.5" y="-4.5" rx="0"
                                                ry="0" opacity="1" stroke-width="0" stroke="none"
                                                stroke-dasharray="0" fill="#fff"></rect>
                                        </clipPath>
                                        <clipPath id="gridRectMarkerMask4w4kvm9i">
                                            <rect width="232" height="70" x="0" y="0" rx="0"
                                                ry="0" opacity="1" stroke-width="0" stroke="none"
                                                stroke-dasharray="0" fill="#fff"></rect>
                                        </clipPath>
                                        <clipPath id="forecastMask4w4kvm9i"></clipPath>
                                        <clipPath id="nonForecastMask4w4kvm9i"></clipPath>
                                        <filter id="SvgjsFilter1373" filterUnits="userSpaceOnUse" width="200%"
                                            height="200%" x="-50%" y="-50%">
                                            <feOffset id="SvgjsFeOffset1366" result="offset" in="SourceGraphic"
                                                dx="5" dy="10">
                                            </feOffset>
                                            <feGaussianBlur id="SvgjsFeGaussianBlur1367" result="blur"
                                                in="offset" stdDeviation="3"></feGaussianBlur>
                                            <feFlood id="SvgjsFeFlood1368" result="flood" in="SourceGraphic"
                                                flood-color="var(--bs-warning)" flood-opacity="0.15">
                                            </feFlood>
                                            <feComposite id="SvgjsFeComposite1369" result="shadow" in="flood"
                                                in2="blur" operator="in">
                                            </feComposite>
                                            <feMerge id="SvgjsFeMerge1370" result="SvgjsFeMerge1370"
                                                in="SourceGraphic">
                                                <feMergeNode id="SvgjsFeMergeNode1371" result="SvgjsFeMergeNode1371"
                                                    in="shadow">
                                                </feMergeNode>
                                                <feMergeNode id="SvgjsFeMergeNode1372" result="SvgjsFeMergeNode1372"
                                                    in="SourceGraphic">
                                                </feMergeNode>
                                            </feMerge>
                                        </filter>
                                    </defs>
                                    <line x1="0" y1="0" x2="0" y2="70"
                                        stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt"
                                        class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="70"
                                        fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1">
                                    </line>
                                    <g class="apexcharts-grid">
                                        <g class="apexcharts-gridlines-horizontal" style="display: none;">
                                            <line x1="0" y1="0" x2="232" y2="0"
                                                stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt"
                                                class="apexcharts-gridline"></line>
                                            <line x1="0" y1="35" x2="232" y2="35"
                                                stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt"
                                                class="apexcharts-gridline"></line>
                                            <line x1="0" y1="70" x2="232" y2="70"
                                                stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt"
                                                class="apexcharts-gridline"></line>
                                        </g>
                                        <g class="apexcharts-gridlines-vertical" style="display: none;">
                                        </g>
                                        <line x1="0" y1="70" x2="232" y2="70"
                                            stroke="transparent" stroke-dasharray="0" stroke-linecap="butt">
                                        </line>
                                        <line x1="0" y1="1" x2="0" y2="70"
                                            stroke="transparent" stroke-dasharray="0" stroke-linecap="butt">
                                        </line>
                                    </g>
                                    <g class="apexcharts-grid-borders" style="display: none;"></g>
                                    <g class="apexcharts-line-series apexcharts-plot-series">
                                        <g class="apexcharts-series" zIndex="0" seriesName="series-1"
                                            data:longestSeries="true" rel="1" data:realIndex="0">
                                            <path
                                                d="M 0 66.5C 16.24 66.5 30.16 10.5 46.4 10.5C 62.64 10.5 76.56 54.25 92.8 54.25C 109.03999999999999 54.25 122.96 19.25 139.2 19.25C 155.44 19.25 169.35999999999999 33.25 185.6 33.25C 201.83999999999997 33.25 215.76 5.25 231.99999999999997 5.25"
                                                fill="none" fill-opacity="1" stroke="var(--bs-warning)"
                                                stroke-opacity="1" stroke-linecap="butt" stroke-width="5"
                                                stroke-dasharray="0" class="apexcharts-line" index="0"
                                                clip-path="url(#gridRectMask4w4kvm9i)"
                                                filter="url(#SvgjsFilter1373)"
                                                pathTo="M 0 66.5C 16.24 66.5 30.16 10.5 46.4 10.5C 62.64 10.5 76.56 54.25 92.8 54.25C 109.03999999999999 54.25 122.96 19.25 139.2 19.25C 155.44 19.25 169.35999999999999 33.25 185.6 33.25C 201.83999999999997 33.25 215.76 5.25 231.99999999999997 5.25"
                                                pathFrom="M 0 70 L 0 70 L 46.4 70 L 92.8 70 L 139.2 70 L 185.6 70 L 231.99999999999997 70"
                                                fill-rule="evenodd"></path>
                                            <g class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown"
                                                data:realIndex="0">
                                                <g class="apexcharts-series-markers">
                                                    <path d="M0,0" fill="var(--bs-warning)" fill-opacity="1"
                                                        stroke="#ffffff" stroke-opacity="0.9"
                                                        stroke-linecap="butt" stroke-width="2"
                                                        stroke-dasharray="0" cx="0" cy="0"
                                                        shape="circle"
                                                        class="apexcharts-marker w9lw736vah no-pointer-events"
                                                        default-marker-size="0"></path>
                                                </g>
                                            </g>
                                        </g>
                                        <g class="apexcharts-datalabels" data:realIndex="0"></g>
                                    </g>
                                    <line x1="0" y1="0" x2="232" y2="0"
                                        stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                        stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
                                    <line x1="0" y1="0" x2="232" y2="0"
                                        stroke="#b6b6b6" stroke-dasharray="0" stroke-width="0"
                                        stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line>
                                    <g class="apexcharts-xaxis" transform="translate(0, 0)">
                                        <g class="apexcharts-xaxis-texts-g" transform="translate(0, -4)">
                                        </g>
                                    </g>
                                    <g class="apexcharts-yaxis-annotations"></g>
                                    <g class="apexcharts-xaxis-annotations"></g>
                                    <g class="apexcharts-point-annotations"></g>
                                </g>
                            </svg>
                            <div class="apexcharts-tooltip apexcharts-theme-light">
                                <div class="apexcharts-tooltip-title"
                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                </div>
                                <div class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-0"
                                    style="order: 1;"><span class="apexcharts-tooltip-marker"
                                        style="background-color: var(--bs-warning);"></span>
                                    <div class="apexcharts-tooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                        <div class="apexcharts-tooltip-y-group"><span
                                                class="apexcharts-tooltip-text-y-label"></span><span
                                                class="apexcharts-tooltip-text-y-value"></span></div>
                                        <div class="apexcharts-tooltip-goals-group"><span
                                                class="apexcharts-tooltip-text-goals-label"></span><span
                                                class="apexcharts-tooltip-text-goals-value"></span></div>
                                        <div class="apexcharts-tooltip-z-group"><span
                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                <div class="apexcharts-yaxistooltip-text"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Fresh payments</h5>
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-primary">See all</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr class="table-dark">
                            <th>ID</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dashboardData['recentPayments'] ?? [] as $payment)
                            <tr>
                                <td>#{{ $payment->id }}</td>
                                <td>{{ $payment->contract?->user?->firstname ?? 'N/A' }}
                                    {{ $payment->contract?->user?->lastname ?? '' }}</td>
                                <td>{{ number_format($payment->expected_amount ?? 0, 0, ',', ' ') }} FCFA</td>
                                <td>
                                    @php $status = $payment->status->code ?? '' @endphp

                                    @if ($payment->isOverdue())
                                        <span class="badge bg-danger">Overdue</span>
                                    @else
                                        @switch($status = $payment->status->code ?? '')
                                            @case('pending')
                                                <span
                                                    class="badge bg-label-warning">{{ $payment->status->label ?? 'Pending' }}</span>
                                            @break

                                            @case('validated')
                                                <span
                                                    class="badge bg-label-success">{{ $payment->status->label ?? 'Validated' }}</span>
                                            @break

                                            @case('processing')
                                                <span
                                                    class="badge bg-label-info">{{ $payment->status->label ?? 'Processing' }}</span>
                                            @break

                                            @case('cancelled')
                                                <span
                                                    class="badge bg-label-secondary">{{ $payment->status->label ?? 'Cancelled' }}</span>
                                            @break

                                            @default
                                                <span class="badge bg-label-light">Unknown</span>
                                        @endswitch
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No payment</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Fresh contracts</h5>
                    <a href="{{ route('contracts.index') }}" class="btn btn-sm btn-primary">See all</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="table-dark">
                                <th>Student</th>
                                <th>Room</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardData['recentContracts'] ?? [] as $contract)
                                <tr>
                                    <td>{{ $contract->user?->firstname ?? 'N/A' }} {{ $contract->user?->lastname ?? '' }}
                                    </td>
                                    <td>{{ $contract->room?->floor?->building?->name ?? 'N/A' }}/F{{ $contract->room?->floor?->number ?? 'N/A' }}/R{{ $contract->room?->number ?? 'N/A' }}
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
                                                <span
                                                    class="badge bg-label-info">{{ $contract->status->label ?? 'Unknown' }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No contract</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
